<?php

use BoergenerWebdesign\BwRegistration\Controller\EventController;
use BoergenerWebdesign\BwRegistration\Controller\ExportController;
use BoergenerWebdesign\BwRegistration\Controller\RegistrationController;
use BoergenerWebdesign\BwRegistration\Controller\SlotController;

if (!defined('TYPO3')) die('Access denied.');

return [
    'bwregistration' => [
        'parent' => 'web',
        'access' => 'user',
        'path' => '/module/bw_registration/',
        'iconIdentifier' => 'bwregistration-bemodules-manage',
        'labels' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang_module_manage.xlf',
        'extensionName' => 'BwRegistration',
        'navigationComponent' => '@typo3/backend/page-tree/page-tree-element',
        'controllerActions' => [
            EventController::class => 'list,show,edit,update,delete,new,create',
            RegistrationController::class => 'revoke, update',
            SlotController::class => 'new,create,edit,update,delete',
            ExportController::class => 'persons,emails'
        ],
    ]
];