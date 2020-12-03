<?php
namespace BoergenerWebdesign\BwRegistration\Domain\Model;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class PrimarySchool extends AbstractEntity {
    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $name = "";
    /**
     * @var ObjectStorage<Registration>
     */
    protected ?ObjectStorage $registrations = null;

    /**
     * PrimarySchool constructor.
     */
    public function __construct() {
        $this -> registrations = new ObjectStorage();
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

}