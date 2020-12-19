<?php
namespace BoergenerWebdesign\BwRegistration\Domain\Model;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Person extends AbstractEntity {
    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $firstName = "";
    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $lastName = "";
    /**
     * @var string
     */
    protected string $streetAndNumber = "";
    /**
     * @var string
     */
    protected string $town = "";
    /**
     * @var string
     */
    protected string $zip = "";
    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $phone = "";
    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("EmailAddress")
     */
    protected string $email = "";
    /**
     * @var Registration
     */
    protected ?Registration $registration = null;

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName) : void {
        $this->firstName = $firstName;
    }
    /**
     * @return string
     */
    public function getFirstName() : string {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName) : void {
        $this->lastName = $lastName;
    }
    /**
     * @return string
     */
    public function getLastName() : string {
        return $this->lastName;
    }

    /**
     * @param string $streetAndNumber
     */
    public function setStreetAndNumber(string $streetAndNumber) : void {
        $this->streetAndNumber = $streetAndNumber;
    }
    /**
     * @return string
     */
    public function getStreetAndNumber() : string {
        return $this->streetAndNumber;
    }

    /**
     * @param string $town
     */
    public function setTown(string $town) : void {
        $this->town = $town;
    }
    /**
     * @return string
     */
    public function getTown() : string {
        return $this->town;
    }

    /**
     * @param string $zip
     */
    public function setZip(string $zip) : void {
        $this->zip = $zip;
    }
    /**
     * @return string
     */
    public function getZip() : string {
        return $this->zip;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone) : void {
        $this->phone = $phone;
    }
    /**
     * @return string
     */
    public function getPhone() : string {
        return $this->phone;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email) : void {
        $this->email = $email;
    }
    /**
     * @return string
     */
    public function getEmail() : string {
        return $this->email;
    }

    /**
     * @return Registration
     */
    public function getRegistration() : ?Registration {
        return $this->registration;
    }
    /**
     * @param Registration $registration
     */
    public function setRegistration(Registration $registration) : void {
        $this->registration = $registration;
    }
}