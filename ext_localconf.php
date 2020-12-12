<?php

call_user_func(
    function($extKey) {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'BwRegistration',
            'register',
            [
                \BoergenerWebdesign\BwRegistration\Controller\RegistrationController::class => 'new,create,success,revoke'
            ],
            // non-cacheable actions
            [
                \BoergenerWebdesign\BwRegistration\Controller\RegistrationController::class => 'new,create,success,revoke'
            ]
        );
    },
    $_EXTKEY
);

// Mail Templates setzen
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths'][1603192568] = 'EXT:bw_registration/Resources/Private/Email/Templates/';