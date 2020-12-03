<?php
namespace BoergenerWebdesign\BwRegistration\Domain\Validator;

use BoergenerWebdesign\BwRegistration\Domain\Model\Registration;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class RegistrationValidator extends AbstractValidator {
    /**
     * @param Registration $registration
     */
    protected function isValid($registration) : void {
        // Prüfen ob der Slot zum Event gehört.
        if($registration -> getSlot() -> getEvent() -> getUid() != $registration -> getEvent() -> getUid()) {
            $this->addError('Der gewählte Zeitraum gehört nicht zum gewünschten Event.', 1603150122);
        }

        // Prüfen ob noch Plätze im Slot frei sind.
        if(!$registration -> getSlot() -> getIsBookable()) {
            $this->addError('Am gewünschten Termin sind nicht mehr genügend Plätze frei.', 1603150059);
        }

        // Prüfen ob soviele Teilnehmer*innen überhaupt erlaubt sind.
        if($registration -> getPersons() -> count() > $registration -> getEvent() -> getPersonsPerRegistration()) {
            $this->addError('Sie können maximal '.$registration -> getEvent() -> getPersonsPerRegistration().' Personen registrieren.', 1603150123);
        }
    }
}