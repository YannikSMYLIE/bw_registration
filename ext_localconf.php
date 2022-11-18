<?php

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

// Mail Templates setzen
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths'][1603192568] = 'EXT:bw_registration/Resources/Private/Email/Templates/';

if (TYPO3_MODE === 'BE') {
    // TypeConverter für hidden Elements
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter(
        \BoergenerWebdesign\BwRegistration\Property\TypeConverters\DeletedRegistrationObjectConverter::class
    );
}