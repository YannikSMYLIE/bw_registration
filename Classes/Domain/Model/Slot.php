<?php
namespace BoergenerWebdesign\BwRegistration\Domain\Model;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectAlreadyRegisteredException;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class Slot extends AbstractEntity {
    /** @var \DateTime  */
    protected ?\DateTime $beginDatetime = null, $endDatetime = null;
    /** @var int  */
    protected int $maxPersons = 0;
    /** @var int  */
    protected int $maxRegistrations = 0;
    /** @var ObjectStorage<Registration>  */
    protected ?ObjectStorage $registrations = null;
    /** @var Event  */
    protected ?Event $event = null;

    public function initializeObject() {
        $this -> registrations = new ObjectStorage();
    }

    /**
     * @return \DateTime
     */
    public function getBeginDatetime() : \DateTime {
        return $this->beginDatetime;
    }
    /**
     * @param array $beginDatetime
     */
    public function setBeginDatetime(array $beginDatetime) : void {
        $this -> beginDatetime = \DateTime::createFromFormat("Y-m-d H:i", $beginDatetime["date"]." ".$beginDatetime["time"]);
    }

    /**
     * @return \DateTime
     */
    public function getEndDatetime() : \DateTime {
        return $this->endDatetime;
    }
    /**
     * @param array $endDatetime
     */
    public function setEndDatetime(array $endDatetime) : void {
        $this -> endDatetime = \DateTime::createFromFormat("Y-m-d H:i", $endDatetime["date"]." ".$endDatetime["time"]);
    }

    /**
     * @return int
     */
    public function getMaxPersons() : int {
        return $this->maxPersons;
    }
    /**
     * @param int $maxPersons
     */
    public function setMaxPersons(int $maxPersons) : void {
        $this->maxPersons = $maxPersons;
    }

    /**
     * @return int
     */
    public function getMaxRegistrations() : int {
        return $this->maxRegistrations;
    }
    /**
     * @param int $maxRegistrations
     */
    public function setMaxRegistrations(int $maxRegistrations) : void {
        $this->maxRegistrations = $maxRegistrations;
    }

    /**
     * @param ObjectStorage<Registration> $registrations
     */
    public function setRegistrations(ObjectStorage $registrations) : void {
        $this->registrations = $registrations;
    }
    /**
     * @return ObjectStorage<Registration>
     */
    public function getRegistrations() : ObjectStorage {
        return $this->registrations;
    }

    /**
     * @return Event
     */
    public function getEvent() : Event {
        return $this->event;
    }
    /**
     * @param Event $event
     */
    public function setEvent(Event $event) : void {
        $this->event = $event;
    }


    /**
     * @return int
     */
    public function getFreeRegistrations() : int {
        return max(0, $this -> getMaxRegistrations() - $this -> getRegistrations() -> count());
    }
    /**
     * Ermittelt wieviele Personen diesen Slot bereits gebucht haben.
     * @return int
     */
    public function getOccupiedPersons() : int {
        $occupiedSeats = 0;
        /** @var Registration $registration */
        foreach($this -> getRegistrations() as $registration) {
            $occupiedSeats += $registration -> getPersons() -> count();
        }
        return $occupiedSeats;
    }
    /**
     * Ermittelt wieviele Personen noch diesen Slot buchen können.
     * @return int
     */
    public function getFreePersons() : int {
        return max(0, $this -> getMaxPersons() - $this -> getOccupiedPersons());
    }

    /**
     * Gibt an ob dieser Slot noch gebucht werden kann.
     * @return bool
     */
    public function getIsBookable() : bool {
        return $this -> getFreePersons() && $this -> getFreeRegistrations();
    }
}