<?php
namespace BoergenerWebdesign\BwRegistration\Domain\Model;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class Event extends AbstractEntity {
    /**
     * @var ObjectStorage<Registration>
     */
    public ?ObjectStorage $registrations = null;
    /**
     * @var ObjectStorage<Slot>
     */
    protected ?ObjectStorage $slots = null;
    /** @var string  */
    protected string $name = "";
    /** @var int  */
    protected int $personsPerRegistration = 0;
    /** @var \DateTime|null  */
    protected ?\DateTime $starttime = null;
    /** @var \DateTime|null  */
    protected ?\DateTime $endtime = null;
    /** @var bool  */
    protected $secret = false;

    /**
     * Event constructor.
     */
    public function initializeObject() {
        $this -> registrations = new ObjectStorage();
        $this -> slots = new ObjectStorage();
    }

    /**
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }
    /**
     * @param string $name
     */
    public function setName(string $name) : void {
        $this->name = $name;
    }

    /**
     * @return ObjectStorage<Registration>
     */
    public function getRegistrations() : ObjectStorage {
        return $this->registrations;
    }
    /**
     * @param ObjectStorage<Registration> $registrations
     */
    public function setRegistrations(ObjectStorage $registrations) : void {
        $this->registrations = $registrations;
    }
    /**
     * @param Registration $registration
     */
    public function addRegistration(Registration $registration) : void {
        $this -> registrations -> attach($registration);
    }
    /**
     * @param Registration $registration
     */
    public function removeRegistration(Registration $registration) : void {
        $this -> registrations -> detach($registration);
    }

    /**
     * Gibt die Anzahl aller registrierten Personen zurück.
     * @return int
     */
    public function getAmountPersons() : int {
        $amount = 0;
        /** @var Registration $registration */
        foreach($this -> registrations as $registration) {
            $amount += $registration -> getPersons() -> count();
        }
        return $amount;
    }

    /**
     * @return int
     */
    public function getPersonsPerRegistration() : int {
        return $this->personsPerRegistration;
    }
    /**
     * @param int $personsPerRegistration
     */
    public function setPersonsPerRegistration(int $personsPerRegistration = 0) : void {
        $this->personsPerRegistration = $personsPerRegistration;
    }

    /**
     * @return ObjectStorage<Slot>
     */
    public function getSlots() : ObjectStorage {
        return $this->slots;
    }
    /**
     * @param ObjectStorage<Slot> $slots
     */
    public function setSlots(ObjectStorage $slots) : void {
        $this->slots = $slots;
    }
    /**
     * @param Slot $slot
     */
    public function addSlot(Slot $slot) : void {
        $this -> slots -> attach($slot);
    }
    /**
     * @param Slot $slot
     */
    public function removeSlot(Slot $slot) : void {
        $this -> slots -> detach($slot);
    }
    /**
     * Gibt die Slots sortiert nach ihrem Starttag zurück.
     * @return array
     */
    public function getSlotsByDate () : array {
        $array = [];
        /** @var Slot $slot */
        foreach($this -> getSlots() as $slot) {
            $array[$slot -> getBeginDatetime() -> format("d.m.Y")][$slot -> getBeginDatetime() -> format("U")."-".$slot -> getUid()] = $slot;
        }

        // Sortieren
        foreach($array as &$date) {
            ksort($date);
        }
        return $array;
    }

    /**
     * @return \DateTime|null
     */
    public function getStarttime() : ?\DateTime {
        return $this->starttime;
    }
    /**
     * @param array $starttime
     */
    public function setStarttime(array $starttime) : void {
        if($starttime["date"] && $starttime["time"]) {
            $this -> starttime = \DateTime::createFromFormat("Y-m-d H:i", $starttime["date"]." ".$starttime["time"]);
        } else {
            $this -> starttime = null;
        }
    }

    /**
     * @return \DateTime|null
     */
    public function getEndtime() : ?\DateTime {
        return $this->endtime;
    }
    /**
     * @param array $endtime
     */
    public function setEndtime(array $endtime) : void {
        if($endtime["date"] && $endtime["time"]) {
            $this -> endtime = \DateTime::createFromFormat("Y-m-d H:i", $endtime["date"]." ".$endtime["time"]);
        } else {
            $this -> starttime = null;
        }
    }

    /**
     * Gibt zurück ob auf das Event derzeit zugegriffen werden kann.
     * @return bool
     */
    public function isAccessible() : bool {
        $currentDatetime = new \DateTime();
        return ($this -> getStarttime() == null || $this -> getStarttime() <= $currentDatetime) && ($this -> getEndtime() == null || $this -> getEndtime() >= $currentDatetime);
    }

    /**
     * @param bool $secret
     */
    public function setSecret(bool $secret) : void {
        $this->secret = $secret;
    }
    /**
     * @return bool
     */
    public function isSecret() : bool {
        return $this->secret;
    }

}