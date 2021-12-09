<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ActiveRecord;

/**
 *
 * @property integer $PK_DOKT
 *
 * @property string $KODS
 * @property integer $TIPS
 * @property string $NOSAUK
 * @property string $VARDS
 * @property string $UZVARDS
 * @property string $REG_NR
 * @property string $PERSKODS
 * @property string $PVN_REGNR
 * @property string $REG_DAT
 * @property integer $PK_VALSTS
 * @property integer $PK_KONTS
 * @property string $ADRESE
 * @property integer $PK_UDFORMA
 * @property string $EPASTS
 * @property string $TELEFONS
 * @property integer $INTEGRATIONUSER
 */
class Creditor extends ActiveRecord
{

    public const TIPS_COMPANY = 3;
    public const TIPS_INDIVIDUAL = 6;
    public const INTEGRATIONUSER_NEAKTIVS = 0;
    public const INTEGRATIONUSER_AKTIVS = 1;
    //use ResourceListTrait;

//    /** @var string */
//    public $KODS;

//    /** @var int */
//    public $TIPS;
//
//    /** @var string */
//    public $NOSAUK;
//
//    /** @var string */
//    public $REG_NR;
//
//    /** @var string */
//    public $REG_DAT;
//
//    /** @var string */
//    public $PVN_REGNR;
//
//    /** @var int */
//    public $PK_VALSTS;
//
//    /** @var int */
//    public $PK_KONTS;
//
//    /** @var string */
//    public $ADRESE;
//
//    /** @var int */
//    public $PK_UDFORMA;
//
//    /** @var string */
//    public $EPASTS;

    public function rules()
    {
        return [
            ['PK_DOKT','integer'],
            ['KODS','string'],
            ['TIPS','integer'],
            ['NOSAUK','string','max' => 250],
            ['REG_NR','string'],
            ['PVN_REGNR','string'],
            ['REG_DAT','string'],
            ['PK_VALSTS','integer'],
            ['PK_KONTS','integer'],
            ['ADRESE','string'],
            ['PK_UDFORMA','integer'],
            ['EPASTS','email'],
        ];
    }

    public function attributes(): array
    {
        return [
            'PK_DOKT',
            'KODS',
            'TIPS',
            'NOSAUK',
            'REG_NR',
            'PVN_REGNR',
            'REG_DAT',
            'PK_VALSTS',
            'PK_KONTS',
            'ADRESE',
            'PK_UDFORMA',
            'EPASTS',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function modelName(): string
    {
        // atgiezj xsd
        //return 'TDdmCustomerKred';

//        $respone = [
//            'description' => 'Veikt datu atlasi',
//            'title' => 'Klientu saraksts',
//           'collection' => [
//            'metadata' => [
//                'page' => [
//                    'count' => 196,
//                    'limited' => false
//                ],
//            'column' => [
//            0 => [
//                'name' => 'K.PK_KLIENTS',
//                        'description' => 'Klients',
//                        'prefix' => '',
//                        'width' => 0,
//                        'columntype' => 'key',
//                        'format' => '',
//                        'type' => 'TDdmCustomer:TDdmCustomerForeignKeyStructure',
//                    ],
//                    1 => [
//            'name' => 'K.COUNTER',
//                        'description' => 'COUNTER',
//                        'prefix' => '',
//                        'width' => 0,
//                        'columntype' => 'counter',
//                        'format' => '',
//                        'type' => 'xsd:integer',
//                    ],
//                ],
//            ],
//            'row' => [
//                0 => [
//                    'K' => [
//                        'PK_KLIENTS' => [
//                            'href' => '/rest/TDdmCustomer/5'
//                        ],
//                        'COUNTER' => 5
//                        ]
//                    ],
//                ],
//            ]
//        ];
//        return 'TDdmKredSar/query';

//                [
//                    'description' => 'Klienta kartīte'
//            'link' => [
//                0 => [
//                    'href' => '/rest/TDdmCustomer/{pk}'
//                    'description' => 'Entītijas ieraksts'
//                ]
//                1 => [
//                'href' => '/rest/TDdmCustomer/ChangePNSKlType'
//                    'description' => 'ChangePNSKlType'
//                ]
//                2 => [
//                'href' => '/rest/TDdmCustomer/setInsertModeEx'
//                    'description' => 'setInsertModeEx'
//                ]
//                3 => [
//                'href' => '/rest/TDdmCustomer/copyFromKeyEx'
//                    'description' => 'copyFromKeyEx'
//                ]
//                4 => [
//                'href' => '/rest/TDdmCustomer/ReadSelectList'
//                    'description' => 'ReadSelectList'
//                ]
//                5 => [
//                'href' => '/rest/TDdmCustomer/ReadAttachmentList'
//                    'description' => 'ReadAttachmentList'
//                ]
//                6 => [
//                'href' => '/rest/TDdmCustomer/Insert'
//                    'description' => 'Insert'
//                ]
//                7 => [
//                'href' => '/rest/TDdmCustomer/Update'
//                    'description' => 'Update'
//                ]
//                8 => [
//                'href' => '/rest/TDdmCustomer/selectFromKey'
//                    'description' => 'selectFromKey'
//                ]
//                9 => [
//                'href' => '/rest/TDdmCustomer/makeCopyFromKey'
//                    'description' => 'makeCopyFromKey'
//                ]
//                10 => [
//                'href' => '/rest/TDdmCustomer/setInsertMode'
//                    'description' => 'setInsertMode'
//                ]
//                11 => [
//                'href' => '/rest/TDdmCustomer/doRegisterBLEvent'
//                    'description' => 'doRegisterBLEvent'
//                ]
//                12 => [
//                'href' => '/rest/TDdmCustomer/getSLName'
//                    'description' => 'getSLName'
//                ]
//                13 => [
//                'href' => '/rest/TDdmCustomer/CountToText'
//                    'description' => 'CountToText'
//                ]
//                14 => [
//                'href' => '/rest/TDdmCustomer/AllowedRight'
//                    'description' => 'AllowedRight'
//                ]
//                15 => [
//                'href' => '/rest/TDdmCustomer/ReadUserParam'
//                    'description' => 'ReadUserParam'
//                ]
//                16 => [
//                'href' => '/rest/TDdmCustomer/GetUzskValPk'
//                    'description' => 'GetUzskValPk'
//                ]
//                17 => [
//                'href' => '/rest/TDdmCustomer/GetReferenceRateFactor'
//                    'description' => 'GetReferenceRateFactor'
//                ]
//                18 => [
//                'href' => '/rest/TDdmCustomer/GetReferencedAmount'
//                    'description' => 'GetReferencedAmount'
//                ]
//                19 => [
//                'href' => '/rest/TDdmCustomer/TDdmCustomer.wadl'
//                    'description' => 'Entītijas resursu apraksts'
//                ]
//                20 => [
//                'href' => '/rest/TDdmCustomer/TDdmCustomer.xsd'
//                    'description' => 'Entītijas datu XSD shēma'
//                ]
//                21 => [
//                'href' => '/rest/TDdmKlSar'
//                    'rel' => 'collection'
//                    'description' => 'Klientu izvēles saraksts'
//                ]
//                22 => [
//                'href' => '/rest/TdmDocTypeSar/query?filter=T.ID eq 3011 and T.AKTIVS eq 0&columns=T.KODS,T.NOSAUK'
//                    'description' => 'Definētie dokumentu tipi'
//                ]
//                23 => [
//                'href' => '/rest/TDdmCustomer/template'
//                    'description' => 'Jauna ieraksta sagataves'
//                ]
//            ]
//            'templates' => [
//                'description' => 'Jauna ieraksta sagataves'
//                'link' => [
//                0 => [
//                    'href' => '/rest/TDdmCustomer/template/2'
//                        'rel' => 'KKLk'
//                        'description' => 'Klients'
//                    ]
//                    1 => [
//                'href' => '/rest/TDdmCustomer/template/356',
//                        'rel' => 'KKLp',
//                        'description' => 'Piegādātājs'
//                    ],
//                    2 => [
//                'href' => '/rest/TDdmCustomer/template/358'
//                        'rel' => 'KKLn',
//                        'description' => 'Neuzskaita'
//                    ]
//                ]
//            ]
//        ];

        /// for findOne
        //return 'TDdmCustomer';

        return 'TDdmCustomer';
    }

    public static function primaryKey(): array
    {
        return ['id'];
    }
}

