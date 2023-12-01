<?php
namespace BoergenerWebdesign\BwRegistration\Domain\Repository;
use BoergenerWebdesign\BwRegistration\Domain\Model\Registration;
use BoergenerWebdesign\BwRegistration\Domain\Model\Slot;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
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

    /**
     * Findet alle entfernten Registrierungen.
     * @param Slot|null $slot
     * @return QueryResultInterface
     */
    public function findDeletedBySlot(?Slot $slot) : QueryResultInterface {
        $query = $this -> createQuery();

        $query -> setQuerySettings(
            $query -> getQuerySettings()
                -> setIncludeDeleted(true)
        );

        $query -> matching(
            $query -> logicalAnd(
                $query -> equals('slot', $slot),
                $query -> equals('deleted', true)
            )
        );
        return $query -> execute();
    }
}