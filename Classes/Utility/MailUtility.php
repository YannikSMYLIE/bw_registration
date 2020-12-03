<?php
namespace BoergenerWebdesign\BwRegistration\Utility;


use BoergenerWebdesign\BwRegistration\Domain\Model\Person;
use BoergenerWebdesign\BwRegistration\Domain\Model\Registration;
use Symfony\Component\Mime\Address;
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Mail\Mailer;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class MailUtility {
    /** @var ConfigurationManager  */
    protected ConfigurationManager $configurationManager;
    /** @var UriBuilder  */
    protected UriBuilder $uriBuilder;

    /**
     * MailUtility constructor.
     * @param ConfigurationManager $configurationManager
     * @param UriBuilder $uriBuilder
     */
    public function __construct(ConfigurationManager $configurationManager, UriBuilder $uriBuilder) {
        $this -> configurationManager = $configurationManager;
        $this -> uriBuilder = $uriBuilder;
    }

    /**
     * Sendet eine Bestätigungs E-Mail.
     * @param Registration $registration
     */
    public function sendConfirmationMail(Registration $registration) : void {
        $this -> sendMail(
            $registration,
            LocalizationUtility::translate('email.confirmation.subject', 'BwRegistration'),
            "Confirmation",
            [
                'registration' => $registration,
                'revokeUri' => $this -> getRevokeLink($registration)
            ]
        );
    }

    /**
     * Sendet eine Widerruf E-Mail.
     * @param Registration $registration
     */
    public function sendRevokeMail(Registration $registration) : void {
        $this -> sendMail(
            $registration,
            LocalizationUtility::translate('email.revoke.subject', 'BwRegistration'),
            "Revoke",
            [
                'registration' => $registration
            ]
        );
    }

    /**
     * Sendet eine E-Mail an alle eingetragenen Personen.
     * @param Registration $registration
     * @param string $subject
     * @param string $template
     * @param array $assigns
     */
    private function sendMail(Registration $registration, string $subject, string $template, array $assigns = []) : void {
        // E-Mail-Adressen ermitteln
        $receivers = [];
        /** @var Person $person */
        foreach($registration -> getPersons() as $person) {
            $receivers[] = new Address($person -> getEmail(), $person -> getFirstName()." ".$person -> getLastName());
        }

        // Mail abschicken
        /** @var FluidEmail $mailMessage */
        $mailMessage = GeneralUtility::makeInstance(FluidEmail::class);
        $mailMessage
            -> from(new Address('noreply@leibniz-ev.de', 'Leibniz e.V.'))
            -> to(...$receivers)
            -> replyTo('vorstand@leibniz-ev.de')
            -> subject($subject)
            -> setTemplate($template)
            -> assignMultiple($assigns);
        GeneralUtility::makeInstance(Mailer::class)->send($mailMessage);
    }

    /**
     * Erzeugt einen Link unter dem die Registrierung widerrufen werden kann.
     * @param Registration $registration
     * @return string
     */
    private function getRevokeLink(Registration $registration) : string {
        // TypeNum ermitteln
        $extbaseFrameworkConfiguration = $this -> configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $pageType = $extbaseFrameworkConfiguration['plugin.']['tx_bwregistration.']['settings.']['standalone.']['typeNum'];

        $uri = $this -> uriBuilder -> reset()
            -> setTargetPageType($pageType)
            -> setCreateAbsoluteUri(true)
            -> uriFor('revoke', [
                'registration' => $registration,
                'hash' => $registration -> getHash()
            ], 'Registration', 'BwRegistration', 'register');
        return $uri;
    }
}