<?php
call_user_func(
    function($extKey)
    {
        if (TYPO3_MODE === 'BE') {
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'BwRegistration',
                'web', // Make module a submodule of 'tools'
                'manage', // Submodule key
                '', // Position
                [   // Actions
                    \BoergenerWebdesign\BwRegistration\Controller\EventController::class => 'list,show,edit,update,delete,new,create',
                    \BoergenerWebdesign\BwRegistration\Controller\RegistrationController::class => 'revoke',
                    \BoergenerWebdesign\BwRegistration\Controller\SlotController::class => 'new,create,edit,update,delete',
                    \BoergenerWebdesign\BwRegistration\Controller\ExportController::class => 'persons,emails'
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:bw_registration/Resources/Public/Icons/Extension.svg',
                    'labels' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang_manage.xlf',
                ]
            );
        }
    },
    $_EXTKEY
);