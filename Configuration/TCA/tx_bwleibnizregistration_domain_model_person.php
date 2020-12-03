<?php
return [
	'ctrl' => [
        'title'	=> 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_person',
        'label' => 'first_name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => '',
        'iconfile' => 'EXT:bw_leibniz_registration/Resources/Public/Icons/Models/tx_bwregistration_domain_model_person.svg'
    ],
	'interface' => [
		'showRecordFieldList' => '',
	],
    'palettes' => [
        'personal' => ['showitem' => 'first_name,last_name'],
        'adress' => ['showitem' => 'street_and_number,zip,town'],
        'contact' => ['showitem' => 'phone,email'],
    ],
	'types' => [
		'0' => ['showitem' => '
		    --palette--;Persönliche Angaben;personal,
		    --palette--;Adressdaten;adress,
		    --palette--;Kontaktinformationen;contact,
		    registration
        '],
	],
	'columns' => [
		'first_name' => [
			'exclude' => true,
			'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_person.first_name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'last_name' => [
			'exclude' => true,
			'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_person.last_name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'street_and_number' => [
			'exclude' => true,
			'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_person.street_and_number',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'zip' => [
			'exclude' => true,
			'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_person.zip',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'town' => [
			'exclude' => true,
			'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_person.town',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'phone' => [
			'exclude' => true,
			'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_person.phone',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'email' => [
			'exclude' => true,
			'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_person.email',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
        'registration' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_leibniz_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_person.registration',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_bwregistration_domain_model_registration'
            ]
        ]
	]
];
