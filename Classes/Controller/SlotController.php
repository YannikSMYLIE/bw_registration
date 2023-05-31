<?php
namespace BoergenerWebdesign\BwRegistration\Controller;
use BoergenerWebdesign\BwRegistration\Domain\Model\Event;
use BoergenerWebdesign\BwRegistration\Domain\Model\Slot;
use BoergenerWebdesign\BwRegistration\Domain\Repository\SlotRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfiguration;

class SlotController extends Controller {
    /** @var SlotRepository */
    protected SlotRepository $slotRepository;

    /**
     * SlotController constructor.
     * @param SlotRepository $slotRepository
     */
    public function __construct(ModuleTemplateFactory $moduleTemplateFactory, SlotRepository $slotRepository) {
        $this -> slotRepository = $slotRepository;
        parent::__construct($moduleTemplateFactory);
    }

    /**
     * Stellt eine Maske zum Erstellen eines Slots zur Verfügung.
     * @param Event $event
     */
    public function newAction(Event $event) : ResponseInterface {
        $this -> view -> assignMultiple([
            'event' => $event
        ]);
        return $this -> htmlResponse();
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
    public function createAction(Slot $slot) : ResponseInterface {
        $this -> slotRepository -> add($slot);
        $this -> addFlashMessage("Der Slot wurde angelegt");
        return $this -> redirect('show', 'Event', null, ['event' => $slot -> getEvent()]);
    }

    /**
     * Stellt eine Maske zum Bearbeiten eines Slots zur Verfügung.
     * @param Slot $slot
     */
    public function editAction(Slot $slot) : ResponseInterface {
        $this -> view -> assignMultiple([
            'slot' => $slot
        ]);
        return $this -> htmlResponse();
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
    public function updateAction(Slot $slot) : ResponseInterface {
        $this -> slotRepository -> update($slot);
        $this -> addFlashMessage('Der Slot wurde aktualisiert');
        return $this -> redirect('show', 'Event', null, ['slot' => $slot, 'event' => $slot -> getEvent()]);
    }

    /**
     * Löscht einen Slot.
     * @param Slot $slot
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function deleteAction(Slot $slot) : ResponseInterface {
        $this -> slotRepository -> remove($slot);
        $this -> addFlashMessage("Der Slot wurde gelöscht");
        return $this -> redirect('show', 'Event', null, ['slot' => $slot, 'event' => $slot -> getEvent()]);
    }
}