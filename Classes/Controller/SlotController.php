<?php
namespace BoergenerWebdesign\BwRegistration\Controller;
use BoergenerWebdesign\BwRegistration\Domain\Model\Event;
use BoergenerWebdesign\BwRegistration\Domain\Model\Slot;
use BoergenerWebdesign\BwRegistration\Domain\Repository\SlotRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfiguration;

class SlotController extends ActionController {
    /** @var SlotRepository */
    protected SlotRepository $slotRepository;

    /**
     * SlotController constructor.
     * @param SlotRepository $slotRepository
     */
    public function __construct(SlotRepository $slotRepositoryy) {
        $this -> slotRepository = $slotRepositoryy;
    }

    /**
     * Stellt eine Maske zum Erstellen eines Slots zur Verfügung.
     * @param Event $event
     */
    public function newAction(Event $event) : void {
        $this -> view -> assignMultiple([
            'event' => $event
        ]);
    }

    /**
     * Passt das Eingabeformat der Zeitangaben an.
     */
    public function initializeCreateAction() : void {
        if($this -> request -> hasArgument('slot')) {
            /** @var MvcPropertyMappingConfiguration $mappingConfiguration */
            $mappingConfiguration = $this->arguments['slot']->getPropertyMappingConfiguration();
            $mappingConfiguration -> setTargetTypeForSubProperty('beginDatetime', 'array');
            $mappingConfiguration -> setTargetTypeForSubProperty('endDatetime', 'array');
        }
    }

    /**
     * Legt einen neuen Slot an.
     * @param Slot $slot
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function createAction(Slot $slot) : void {
        $this -> slotRepository -> add($slot);
        $this -> addFlashMessage("Der Slot wurde angelegt");
        $this -> redirect('show', 'Event', null, ['event' => $slot -> getEvent()]);
    }

    /**
     * Stellt eine Maske zum Bearbeiten eines Slots zur Verfügung.
     * @param Slot $slot
     */
    public function editAction(Slot $slot) : void {
        $this -> view -> assignMultiple([
            'slot' => $slot
        ]);
    }

    /**
     * Passt das Eingabeformat der Zeitangaben an.
     */
    public function initializeUpdateAction() : void {
        if($this -> request -> hasArgument('slot')) {
            /** @var MvcPropertyMappingConfiguration $mappingConfiguration */
            $mappingConfiguration = $this->arguments['slot']->getPropertyMappingConfiguration();
            $mappingConfiguration -> setTargetTypeForSubProperty('beginDatetime', 'array');
            $mappingConfiguration -> setTargetTypeForSubProperty('endDatetime', 'array');
        }
    }

    /**
     * Speichert die Änderungen an einem Slot.
     * @param Slot $slot
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function updateAction(Slot $slot) : void {
        $this -> slotRepository -> update($slot);
        $this -> addFlashMessage('Der Slot wurde aktualisiert');
        $this -> redirect('show', 'Event', null, ['slot' => $slot, 'event' => $slot -> getEvent()]);
    }

    /**
     * Löscht einen Slot.
     * @param Slot $slot
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function deleteAction(Slot $slot) : void {
        $this -> slotRepository -> remove($slot);
        $this -> addFlashMessage("Der Slot wurde gelöscht");
        $this -> redirect('show', 'Event', null, ['slot' => $slot, 'event' => $slot -> getEvent()]);
    }
}