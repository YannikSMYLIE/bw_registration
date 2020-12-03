<?php
namespace BoergenerWebdesign\BwRegistration\Domain\Repository;
use BoergenerWebdesign\BwRegistration\Domain\Model\Registration;
use TYPO3\CMS\Extbase\Persistence\Repository;

class RegistrationRepository extends Repository {
    /**
     * Fügt eine Registrierung hinzu.
     * @param Registration $registration
     */
    public function add($registration) : void {
        $hashbytes = random_bytes(20);
        $hash = bin2hex($hashbytes);
        $registration -> setHash($hash);
        parent::add($registration);
    }
}