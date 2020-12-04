<?php
namespace BoergenerWebdesign\BwRegistration\Domain\Model;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Registration extends AbstractEntity {
    /** @var ObjectStorage<Person> */
    protected ?ObjectStorage $persons = null;
    /** @var string */
    protected string $hash = "";
    /**
     * @var Slot
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected ?Slot $slot = null;
    /**
     * @var Event
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected ?Event $event = null;


    /**
     * Registration constructor.
     */
    public function initializeObject() {
        $this -> persons = new ObjectStorage();
    }

    /**
     * @return ObjectStorage<Person>
     */
    public function getPersons() : ObjectStorage {
        return $this->persons;
    }
    /**
     * @param ObjectStorage<Person> $persons
     */
    public function setPersons(ObjectStorage $persons) : void {
        $this->persons = $persons;
    }

    /**
     * @param Slot $slot
     */
    public function setSlot(Slot $slot) : void {
        $this->slot = $slot;
    }
    /**
     * @return Slot
     */
    public function getSlot() : ?Slot {
        return $this->slot;
    }

    /**
     * @return string
     */
    public function getHash() : string {
        return $this->hash;
    }
    /**
     * @param string $hash
     */
    public function setHash(string $hash) : void {
        $this->hash = $hash;
    }

    /**
     * @return Event
     */
    public function getEvent() : Event{
        return $this->event;
    }
    /**
     * @param Event $event
     */
    public function setEvent(Event $event) : void {
        $this->event = $event;
    }
}