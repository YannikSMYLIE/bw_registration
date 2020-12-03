<?php
return [
	'ctrl' => [
        'title'	=> 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_primaryschool',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => '',
        'iconfile' => 'EXT:bw_registration/Resources/Public/Icons/Models/tx_bwregistration_domain_model_primaryschool.svg'
    ],
	'interface' => [
		'showRecordFieldList' => '',
	],
	'types' => [
		'0' => ['showitem' => 'name,registrations'],
	],
	'columns' => [
		'name' => [
			'exclude' => true,
			'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_primaryschool.name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
        'registrations' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_primaryschool.registrations',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_bwregistration_domain_model_registration',
                'foreign_field' => 'primary_school',
            ]
        ]
	]
];
