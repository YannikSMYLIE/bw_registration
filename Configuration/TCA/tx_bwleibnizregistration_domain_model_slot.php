<?php
return [
	'ctrl' => [
        'title'	=> 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_slot',
        'label' => 'begin_datetime',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => '',
        'iconfile' => 'EXT:bw_leibniz_registration/Resources/Public/Icons/Models/tx_bwregistration_domain_model_slot.svg'
    ],
	'interface' => [
		'showRecordFieldList' => '',
	],
    'palettes' => [
        'datetimes' => ['showitem' => 'begin_datetime, end_datetime'],
        'limits' => ['showitem' => 'max_registrations, max_persons']
    ],
	'types' => [
		'0' => ['showitem' => '
		    event,
		    --palette--;LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_slot.palettes.datetimes;datetimes,
		    --palette--;LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_slot.palettes.limits;limits,
		    registrations
        ']
	],
	'columns' => [
        'begin_datetime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_slot.begin_datetime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'dbType' => 'datetime',
                'eval' => 'datetime,required'
            ]
        ],
        'end_datetime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_slot.end_datetime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'dbType' => 'datetime',
                'eval' => 'datetime,required'
            ]
        ],
        'event' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_bwregistration_domain_model_event',
            ]
        ],
        'registrations' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_slot.registrations',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_bwregistration_domain_model_registration',
                'foreign_field' => 'slot',
                'appearance' => [
                    'collapseAll' => true
                ]
            ]
        ],
        'max_persons' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_slot.max_persons',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'int,required'
            ]
        ],
        'max_registrations' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_slot.max_registrations',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'int,required'
            ]
        ]
	]
];
