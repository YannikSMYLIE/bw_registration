<?php
return [
	'ctrl' => [
        'title'	=> 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => '',
        'iconfile' => 'EXT:bw_registration/Resources/Public/Icons/Models/tx_bwregistration_domain_model_event.svg'
    ],
	'interface' => [
		'showRecordFieldList' => '',
	],
    'palettes' => [
        'access_times' => [
            'showitem' => 'starttime,endtime',
        ],
        'registration' => [
            'showitem' => 'persons_per_registration,secret',
        ]
    ],
	'types' => [
		'0' => ['showitem' => '
            name,
            --palette--;LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event.palettes.access_times;access_times,
            slots,
            --palette--;LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event.palettes.registration;registration,
            registrations
		'],
	],
	'columns' => [
		'name' => [
			'exclude' => true,
			'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event.name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'required,trim'
			],
		],
        'persons_per_registration' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event.persons_per_registration',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'int'
            ],
        ],
        'registrations' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event.registrations',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bwregistration_domain_model_registration',
                'foreign_field' => 'event',
            ]
        ],
        'slots' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event.slots',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bwregistration_domain_model_slot',
                'foreign_field' => 'event',
            ]
        ],
        'starttime' => [
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'dbType' => 'datetime',
                'eval' => 'datetime',
            ],
        ],
        'endtime' => [
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'dbType' => 'datetime',
                'eval' => 'datetime',
            ],
        ],
        'secret' => [
            'exclude' => true,
            'label' => 'LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event.secret',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['LLL:EXT:bw_registration/Resources/Private/Language/locallang.xlf:tx_bwregistration_domain_model_event.secret.checkbox', 1],
                ],
            ]
        ],
	]
];
