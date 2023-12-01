<?php
namespace BoergenerWebdesign\BwRegistration\Utility;


use BoergenerWebdesign\BwRegistration\Domain\Model\Person;
use BoergenerWebdesign\BwRegistration\Domain\Model\Registration;
use Symfony\Component\Mime\Address;
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Mail\Mailer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class MailUtility {
    /** @var array  */
    protected array $settings = [];
    /** @var UriBuilder  */
    protected UriBuilder $uriBuilder;

    /**
     * MailUtility constructor.
     * @param ConfigurationManager $configurationManager
     * @param UriBuilder $uriBuilder
     */
    public function __construct(ConfigurationManager $configurationManager, UriBuilder $uriBuilder) {
        $this -> uriBuilder = $uriBuilder;

        try {
            $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
            $this -> settings = $extbaseFrameworkConfiguration['plugin.']['tx_bwregistration.']['settings.'];
        } catch(\Exception $e) {}
    }

    /**
     * Sends registration confirmation.
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
     * Sends information about revocation of a registration.
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
     * Sends an email.
     * @param Registration $registration
     * @param string $subject
     * @param string $template
     * @param array $assigns
     */
    private function sendMail(Registration $registration, string $subject, string $template, array $assigns = []) : void {
        /** @var FluidEmail $mailMessage */
        $mailMessage = GeneralUtility::makeInstance(FluidEmail::class);
        $mailMessage
            -> to(...$this -> getReceivers($registration))
            -> subject($subject)
            -> setTemplate($template)
            -> assignMultiple($assigns);

        $sender = $this -> getSender();
        if($sender) {
            $mailMessage -> from($sender);
        }

        $replyTo = $this -> getReplyTo();
        if($replyTo) {
            $mailMessage -> replyTo($replyTo);
        }

        GeneralUtility::makeInstance(Mailer::class)->send($mailMessage);
    }

    /**
     * Creates the revoke link.
     * @param Registration $registration
     * @return string
     */
    private function getRevokeLink(Registration $registration) : string {
        $uri = $this -> uriBuilder -> reset()
            -> setTargetPageType($this -> settings['standalone.']['typeNum'])
            -> setCreateAbsoluteUri(true)
            -> uriFor('revoke', [
                'registration' => $registration,
                'hash' => $registration -> getHash()
            ], 'Registration', 'BwRegistration', 'register');
        return $uri;
    }

    /**
     * Returns the addresses of the receivers.
     * @param Registration $registration
     * @return array
     */
    public function getReceivers(Registration $registration) : array {
        $receivers = [];
        /** @var Person $person */
        foreach($registration -> getPersons() as $person) {
            $receivers[] = new Address($person -> getEmail(), $person -> getFirstName()." ".$person -> getLastName());
        }
        return $receivers;
    }

    /**
     * Returns the sender address.
     * @return Address|null
     */
    public function getSender() : ?Address {
        if(key_exists("sender.", $this -> settings) && key_exists("email", $this -> settings["sender."]) && $this -> settings["sender."]["email"]) {
            if(key_exists("name", $this -> settings["sender."]) && $this -> settings["sender."]["name"]) {
                return new Address($this -> settings["sender."]["email"],$this -> settings["sender."]["name"]);
            } else {
                return new Address($this -> settings["sender."]["email"]);
            }
        }
        return null;
    }

    /**
     * Returns the reply to address.
     * @return Address|null
     */
    public function getReplyTo() : ?Address {
        if(key_exists("replyTo.", $this -> settings) && key_exists("email", $this -> settings["replyTo."]) && $this -> settings["replyTo."]["email"]) {
            if(key_exists("name", $this -> settings["replyTo."]) && $this -> settings["replyTo."]["name"]) {
                return new Address($this -> settings["replyTo."]["email"],$this -> settings["replyTo."]["name"]);
            } else {
                return new Address($this -> settings["replyTo."]["email"]);
            }
        }
        return null;
    }
}