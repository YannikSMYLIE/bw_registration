<?php
namespace BoergenerWebdesign\BwRegistration\Controller;
use BoergenerWebdesign\BwRegistration\Domain\Model\Event;
use BoergenerWebdesign\BwRegistration\Domain\Model\Person;
use BoergenerWebdesign\BwRegistration\Domain\Model\Registration;
use BoergenerWebdesign\BwRegistration\Domain\Model\Slot;
use BoergenerWebdesign\BwRegistration\Domain\Repository\EventRepository;
use BoergenerWebdesign\BwRegistration\Utility\CsvUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfiguration;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class EventController extends ActionController {
    /** @var EventRepository  */
    protected EventRepository $eventRepository;

    /**
     * EventController constructor.
     * @param EventRepository $eventRepository
     */
    public function __construct(EventRepository $eventRepository) {
        $this -> eventRepository = $eventRepository;
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
            'slot' => $slot
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

    /**
     * Exportiert die Registrierungen als CSV Datei.
     * @param Event $event
     * @param Slot|null $slot
     */
    public function exportAction(Event $event, ?Slot $slot = null) : void {
        $slots = $slot ? [$slot] : $event -> getSlots() -> toArray();

        $persons = [
            [
                "Slot Uid",
                "Slot Beginn",
                "Slot Ende",
                "Registrierung Uid",
                "Probeunterrichtsstunde",
                "Führung",
                "Grundschule",
                "Vorname",
                "Nachname",
                "Straße und Hausnummer",
                "PLZ",
                "Stadt",
                "Telefon",
                "E-Mail"
            ]
        ];
        /** @var Slot $slot */
        foreach($slots as $slot) {
            /** @var Registration $registration */
            foreach($slot -> getRegistrations() as $registration) {
                /** @var Person $person */
                foreach($registration -> getPersons() as $person) {
                    $persons[] = [
                        $slot -> getUid(),
                        $slot -> getBeginDatetime() -> format("d.m.Y H:i"),
                        $slot -> getEndDatetime() -> format("d.m.Y H:i"),
                        $registration -> getUid(),
                        $registration -> getLesson() ? "ja" : "nein",
                        $registration -> getTour() ? "ja" : "nein",
                        $registration -> getPrimarySchool() -> getName(),
                        $person -> getFirstName(),
                        $person -> getLastName(),
                        $person -> getStreetAndNumber(),
                        $person -> getZip(),
                        $person -> getTown(),
                        $person -> getPhone(),
                        $person -> getEmail()
                    ];
                }
            }
        }

        // CSV Datei schreiben
        CsvUtility::write($persons);
    }
}