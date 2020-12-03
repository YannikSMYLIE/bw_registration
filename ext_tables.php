<?php
call_user_func(
    function($extKey)
    {
        if (TYPO3_MODE === 'BE') {
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'BoergenerWebdesign.BwRegistration',
                'web', // Make module a submodule of 'tools'
                'manage', // Submodule key
                '', // Position
                [   // Actions
                    'Event' => 'list,show,edit,update,delete,new,create',
                    'Registration' => 'revoke',
                    'Slot' => 'new,create,edit,update,delete',
                    'Export' => 'persons,emails',
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