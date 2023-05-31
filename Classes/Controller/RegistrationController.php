<?php
namespace BoergenerWebdesign\BwRegistration\Controller;
use BoergenerWebdesign\BwRegistration\Domain\Model\Event;
use BoergenerWebdesign\BwRegistration\Domain\Model\Registration;
use BoergenerWebdesign\BwRegistration\Domain\Repository\EventRepository;
use BoergenerWebdesign\BwRegistration\Domain\Repository\PrimarySchoolRepository;
use BoergenerWebdesign\BwRegistration\Domain\Repository\RegistrationRepository;
use BoergenerWebdesign\BwRegistration\Domain\Repository\SlotRepository;
use BoergenerWebdesign\BwRegistration\Utility\MailUtility;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Error\Result;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfiguration;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class RegistrationController extends Controller {
    /** @var SlotRepository */
    protected SlotRepository $slotRepository;
    /** @var RegistrationRepository  */
    protected RegistrationRepository $registrationRepository;
    /** @var EventRepository */
    protected EventRepository $eventRepository;
    /** @var MailUtility  */
    protected MailUtility $mailUtility;
    /** @var PersistenceManager  */
    protected PersistenceManager $persistanceManager;

    /**
     * RegistrationController constructor.
     * @param SlotRepository $slotRepository
     * @param RegistrationRepository $registrationRepository
     * @param EventRepository $eventRepository
     * @param MailUtility $mailUtility
     * @param PersistenceManager $persistenceManager
     */
    public function __construct(
        ModuleTemplateFactory $moduleTemplateFactory,
        SlotRepository $slotRepository,
        RegistrationRepository $registrationRepository,
        EventRepository $eventRepository,
        MailUtility $mailUtility,
        PersistenceManager $persistenceManager
    ) {
        $this -> slotRepository = $slotRepository;
        $this -> registrationRepository = $registrationRepository;
        $this -> eventRepository = $eventRepository;
        $this -> mailUtility = $mailUtility;
        $this -> persistanceManager = $persistenceManager;
        parent::__construct($moduleTemplateFactory);
    }

    /**
     * Stellt eine Maske zur Registrierung zur Verfügung.
     * @param Event|null $event
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function newAction(Event $event = null) : ResponseInterface {
        // Originale Anfrage einlesen
        if($this -> request -> getOriginalRequest()) {
            $registration = $this -> request -> getOriginalRequest() -> getArgument('registration');
            $errors = $this -> request -> getOriginalRequestMappingResults();
            $registration = $this -> replaceIndexWithTempUids($registration, $errors);
            $this -> view -> assign('registration', $registration);
        }

        // Event einlesen
        if(!$event) {
            $eventUid = $_GET["event"] ?? $_POST["event"] ?? 0;
            if($registration) {
                $eventUid = $registration["event"];
            }

            if(!$eventUid) {
                throw new \Exception("Es wurde kein Event angegeben.", 1603639719);
            }
            $event = $this -> eventRepository -> findByUid($eventUid);
        }
        if(!$event) {
            throw new \Exception("Das angegebene Event konnte leider nicht gefunden werden.", 1603639720);
        }

        if($event -> isAccessible()) {
            $this->view->assignMultiple([
                'slots' => $this->slotRepository->findByEvent($event),
                'event' => $event
            ]);
        } else {
            $this -> view -> assign('notAccessible', true);
        }

        return $this -> htmlResponse();
    }

    /**
     * Schaltet beliebig viele Personen frei.
     */
    public function initializeCreateAction() : void {
        if($this -> request -> hasArgument('registration')) {
            $mappingConfiguration = $this -> arguments -> getArgument('registration') -> getPropertyMappingConfiguration();
            $mappingConfiguration -> forProperty('persons') -> allowAllProperties();
            $mappingConfiguration -> allowCreationForSubProperty('persons');

            foreach($this -> request -> getArgument('registration')["persons"] as $key => $value) {
                $mappingConfiguration -> forProperty('persons') -> forProperty($key) -> allowAllProperties();
                $mappingConfiguration -> forProperty('persons') -> allowCreationForSubProperty($key);
            }
        }
    }

    /**
     * Erstellt eine neue Registrierung.
     * @param Registration $registration
     * @TYPO3\CMS\Extbase\Annotation\Validate(param="registration", validator="BoergenerWebdesign\BwRegistration\Domain\Validator\RegistrationValidator")
     */
    public function createAction(Registration $registration) : ResponseInterface {
        if(!$registration -> getEvent() -> isAccessible()) {
            throw new \Exception("Die Registrierung für dieses Event ist geschlossen.", 1604388337);
        }

        $this -> registrationRepository -> add($registration);

        // Alles persistieren
        $this -> persistNow();

        // E-Mail
        $this -> mailUtility -> sendConfirmationMail($registration);

        // Uri bauen
        $uri = $this -> uriBuilder -> reset()
            -> setTargetPageType($GLOBALS["TSFE"] -> type)
            -> uriFor('success', [
                'registration' => $registration,
                'hash' => $registration -> getHash()
            ], 'Registration', 'BwRegistration', 'register');
        return $this -> redirectToUri($uri);
    }

    /**
     * @param Registration $registration
     * @param string $hash
     * @return ResponseInterface
     */
    public function successAction(Registration $registration, string $hash) : ResponseInterface {
        if($registration -> getHash() == $hash) {
            $this -> view -> assign('registration', $registration);
        }
        return $this -> htmlResponse();
    }

    /**
     * Widerruft eine Registrierung.
     * @param Registration|null $registration
     * @param string $hash
     * @param bool $notify
     * @return ResponseInterface
     * @throws IllegalObjectTypeException
     */
    public function revokeAction(Registration $registration = null, string $hash = "", bool $notify = true) : ResponseInterface {
        if(ApplicationType::fromRequest($this -> request)->isBackend()) {
            $this -> registrationRepository -> remove($registration);
            if($notify) {
                $this -> mailUtility -> sendRevokeMail($registration);
            }

            $this -> addFlashMessage("Die Registrierung wurde erfolgreich storiert!");
            return $this -> redirect('show', 'Event', null, ['event' => $registration -> getEvent(), 'slot' => $registration -> getSlot()]);
        } else if($registration && $registration -> getHash() == $hash) {

            if((new \DateTime()) >= $registration -> getSlot() -> getBeginDatetime()) {
                $this -> view -> assign('error', 'Die Registrierung konnte nicht storniert werden, da die Veranstaltung bereits stattgefunden hat.');
            } else if($registration -> isAttended()) {
                $this -> view -> assign('error', 'Die Registrierung konnte nicht storniert werden, weil Sie bereits an der Veranstaltung teilgenommen haben.');
            } else {
                $this -> registrationRepository -> remove($registration);
                $this -> mailUtility -> sendRevokeMail($registration);
            }

            $this -> view -> assign('registration', $registration);
            $this -> htmlResponse();
        }
    }

    /**
     * Passt das Eingabeformat der Zeitangaben an.
     */
    public function initializeUpdateAction() : void {
        if($this -> request -> hasArgument('registration')) {
            /** @var MvcPropertyMappingConfiguration $mappingConfiguration */
            $mappingConfiguration = $this->arguments['registration']->getPropertyMappingConfiguration();
            $mappingConfiguration -> setTargetTypeForSubProperty('attendedTime', 'array');
        }
    }

    /**
     * Aktualisiert eine Registrierung.
     * @param Registration $registration
     * @return ResponseInterface
     * @throws IllegalObjectTypeException
     * @throws UnknownObjectException
     */
    public function updateAction(Registration $registration) : ResponseInterface {
        $this -> registrationRepository -> update($registration);
        $this -> addFlashMessage('Die Registrierung wurde aktualisiert.');
        return $this -> redirect('show', 'Event', null, ['event' => $registration -> getEvent(), 'slot' => $registration -> getSlot()]);
    }

    /**
     * Tauscht die Indexe der Personen mit ihren temporären Uids aus.
     * @param array $registration
     * @param Result $errors
     * @return array
     */
    private function replaceIndexWithTempUids(array $registration, Result $errors) : array {
        $persons = [];
        $personErrors = $errors ->forProperty('registration')->forProperty('persons');

        $i = 0;
        $personIndex = array_keys($registration["persons"]);
        foreach($personErrors -> getSubResults() as $key => $error) {
            $registration["persons"][$personIndex[$i]]["uid"] = $key;
            $i++;
        }
        return $registration;
    }

    /**
     * Persistiert alle Änderungen.
     */
    private function persistNow() : void {
        $this -> persistanceManager -> persistAll();
    }
}