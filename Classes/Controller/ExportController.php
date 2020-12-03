<?php
namespace BoergenerWebdesign\BwRegistration\Controller;
use BoergenerWebdesign\BwRegistration\Domain\Model\Event;
use BoergenerWebdesign\BwRegistration\Domain\Model\Person;
use BoergenerWebdesign\BwRegistration\Domain\Model\Registration;
use BoergenerWebdesign\BwRegistration\Domain\Model\Slot;
use BoergenerWebdesign\BwRegistration\Domain\Repository\EventRepository;
use BoergenerWebdesign\BwRegistration\Utility\CsvUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ExportController extends ActionController {
    /**
     * Exportiert die Registrierungen als CSV Datei.
     * @param Event $event
     * @param Slot|null $slot
     */
    public function personsAction(Event $event, ?Slot $slot = null) : void {
        $slots = $slot ? [$slot] : $event -> getSlots() -> toArray();

        $persons = [
            [
                "Slot Uid",
                "Slot Beginn",
                "Slot Ende",
                "Registrierung Uid",
                "Probeunterrichtsstunde",
                "Führung",
                "Grundschule",
                "Vorname",
                "Nachname",
                "Straße und Hausnummer",
                "PLZ",
                "Stadt",
                "Telefon",
                "E-Mail"
            ]
        ];
        /** @var Slot $slot */
        foreach($slots as $slot) {
            /** @var Registration $registration */
            foreach($slot -> getRegistrations() as $registration) {
                /** @var Person $person */
                foreach($registration -> getPersons() as $person) {
                    $persons[] = [
                        $slot -> getUid(),
                        $slot -> getBeginDatetime() -> format("d.m.Y H:i"),
                        $slot -> getEndDatetime() -> format("d.m.Y H:i"),
                        $registration -> getUid(),
                        $registration -> getLesson() ? "ja" : "nein",
                        $registration -> getTour() ? "ja" : "nein",
                        $registration -> getPrimarySchool() -> getName(),
                        $person -> getFirstName(),
                        $person -> getLastName(),
                        $person -> getStreetAndNumber(),
                        $person -> getZip(),
                        $person -> getTown(),
                        $person -> getPhone(),
                        $person -> getEmail()
                    ];
                }
            }
        }

        // CSV Datei schreiben
        CsvUtility::write($persons, "Teilnehmer ".$event -> getName());
    }

    public function emailsAction(Event $event, ?Slot $slot = null) : void {
        $slots = $slot ? [$slot] : $event->getSlots()->toArray();

        $emails = [];
        /** @var Slot $slot */
        foreach($slots as $slot) {
            /** @var Registration $registration */
            foreach ($slot->getRegistrations() as $registration) {
                /** @var Person $person */
                foreach ($registration->getPersons() as $person) {
                    $emails[$person -> getEmail()] = $person -> getEmail();
                }
            }
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=E-Mail-Adressen.txt');
        $output = fopen('php://output', 'w');

        /** @var string $email */
        foreach($emails as $email) {
            fwrite($output, $email.",\n");
        }
        die();
    }
}