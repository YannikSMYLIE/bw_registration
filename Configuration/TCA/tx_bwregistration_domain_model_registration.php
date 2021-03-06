<?php
return [
	'ctrl' => [
        'title'	=> 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_registration',
        'label' => 'uid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => '',
        'iconfile' => 'EXT:bw_registration/Resources/Public/Icons/Models/tx_bwregistration_domain_model_registration.svg'
    ],
	'interface' => [
		'showRecordFieldList' => '',
	],
    'palettes' => [
        'attendance' => [
            'showitem' => 'attended,attended_time',
        ]
    ],
	'types' => [
		'0' => ['showitem' => '
		    slot,
		    persons,hash,
            --palette--;LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_registration.palettes.attendance;attendance
        ']
	],
	'columns' => [
        'event' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_bwregistration_domain_model_event'
            ]
        ],
        'persons' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_registration.persons',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bwregistration_domain_model_person',
                'foreign_field' => 'registration',
                'appearance' => [
                    'collapseAll' => true
                ]
            ]
        ],
        'slot' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_registration.slot',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_bwregistration_domain_model_slot',
                'foreign_table_where' => 'AND {#tx_bwregistration_domain_model_slot}.{#event} = ###REC_FIELD_event###'
            ]
        ],
        'hash' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_registration.hash',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ]
        ],
        'attended' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_registration.attended',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_registration.attended.checkbox', 1],
                ],
            ]
        ],
        'attended_time' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_registration.attended_time',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'dbType' => 'datetime',
                'eval' => 'datetime'
            ]
        ],
        'deleted' => [
            'exclude' => true,
            'label' => 'Gelöscht',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['Die Registrierung ist gelöscht.', 1],
                ],
            ]
        ],
	]
];
