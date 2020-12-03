<?php

call_user_func(
    function($extKey) {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'BoergenerWebdesign.BwRegistration',
            'register',
            [
                'Registration' => 'new,create,success,revoke'
            ],
            // non-cacheable actions
            [
                'Registration' => 'new,create,success,revoke'
            ]
        );
    },
    $_EXTKEY
);

// Mail Templates setzen
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths'][1603192568] = 'EXT:bw_registration/Resources/Private/Email/Templates/';