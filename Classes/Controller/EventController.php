<?php
namespace BoergenerWebdesign\BwRegistration\Controller;
use BoergenerWebdesign\BwRegistration\Domain\Model\Event;
use BoergenerWebdesign\BwRegistration\Domain\Model\Person;
use BoergenerWebdesign\BwRegistration\Domain\Model\Registration;
use BoergenerWebdesign\BwRegistration\Domain\Model\Slot;
use BoergenerWebdesign\BwRegistration\Domain\Repository\EventRepository;
use BoergenerWebdesign\BwRegistration\Domain\Repository\RegistrationRepository;
use BoergenerWebdesign\BwRegistration\Utility\CsvUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfiguration;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class EventController extends ActionController {
    /** @var EventRepository  */
    protected EventRepository $eventRepository;
    /** @var RegistrationRepository  */
    protected RegistrationRepository $registrationRepository;

    /**
     * EventController constructor.
     * @param EventRepository $eventRepository
     * @param RegistrationRepository $registrationRepository
     */
    public function __construct(EventRepository $eventRepository, RegistrationRepository $registrationRepository) {
        $this -> eventRepository = $eventRepository;
        $this -> registrationRepository = $registrationRepository;
    }

    /**
     * Stellt eine Maske zum Erstellen von Events zur Verfügung.
     */
    public function newAction() : void {
    }

    /**
     * Passt das Eingabeformat der Zeitangaben an.
     */
    public function initializeCreateAction() : void {
        if($this -> request -> hasArgument('event')) {
            /** @var MvcPropertyMappingConfiguration $mappingConfiguration */
            $mappingConfiguration = $this->arguments['event']->getPropertyMappingConfiguration();
            $mappingConfiguration -> setTargetTypeForSubProperty('starttime', 'array');
            $mappingConfiguration -> setTargetTypeForSubProperty('endtime', 'array');
        }
    }

    /**
     * Erstellt ein neues Event.
     * @param Event $event
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function createAction(Event $event) : void {
        $this -> eventRepository -> add($event);
        $this -> addFlashMessage("Die Veranstaltung wurde erstellt.");
        $this -> redirect('list');
    }

    /**
     * Listet alle Events im Backend auf.
     */
    public function listAction() : void {
        $events = $this -> eventRepository -> findAll();
        $this -> view -> assignMultiple([
            'events' => $events
        ]);
    }

    /**
     * Zeigt ein einzelnes Event.
     * @param Event $event
     * @param Slot|null $slot
     */
    public function showAction(Event $event, ?Slot $slot = null) : void {
        if(!$slot) {
            $event -> getSlots() -> rewind();
            $slot = $event -> getSlots() -> current();
        }
        $this -> view -> assignMultiple([
            'event' => $event,
            'slot' => $slot,
            'registrations' => $this -> registrationRepository -> findBySlot($slot),
            'deletedRegistrations' => $this -> registrationRepository -> findDeletedBySlot($slot)
        ]);
    }

    /**
     * Stellt eine Maske zum Bearbeiten eines Events zur Verfügung.
     * @param Event $event
     */
    public function editAction(Event $event) : void {
        $this -> view -> assignMultiple([
            'event' => $event
        ]);
    }

    /**
     * Passt das Eingabeformat der Zeitangaben an.
     */
    public function initializeUpdateAction() : void {
        if($this -> request -> hasArgument('event')) {
            /** @var MvcPropertyMappingConfiguration $mappingConfiguration */
            $mappingConfiguration = $this->arguments['event']->getPropertyMappingConfiguration();
            $mappingConfiguration -> setTargetTypeForSubProperty('starttime', 'array');
            $mappingConfiguration -> setTargetTypeForSubProperty('endtime', 'array');
        }
    }

    /**
     * Aktualisiert ein Event.
     * @param Event $event
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function updateAction(Event $event) : void {
        $this -> eventRepository -> update($event);
        $this -> addFlashMessage("Die Veranstaltung wurde aktualisiert");
        $this -> redirect('list');
    }
    
    public function deleteAction(Event $event) : void {
        $this -> eventRepository -> remove($event);
        $this -> addFlashMessage("Die Veranstaltung wurde gelöscht.");
        $this -> redirect('list');
    }
}