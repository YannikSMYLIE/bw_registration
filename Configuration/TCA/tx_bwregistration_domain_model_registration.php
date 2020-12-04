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
	'types' => [
		'0' => ['showitem' => '
		    slot,
		    persons,hash
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
	]
];
