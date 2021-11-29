<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\models\traits\ResourceListTrait;
use simialbi\yii2\rest\ActiveRecord;

class Creditor extends ActiveRecord
{
    use ResourceListTrait;

    /** @var string */
    public $KODS;

    /** @var int */
    public $TIPS;

    /** @var string */
    public $NOSAUK;

    /** @var string */
    public $REG_NR;

    /** @var string */
    public $REG_DAT;

    /** @var string */
    public $PVN_REGNR;

    /** @var int */
    public $PK_VALSTS;

    /** @var int */
    public $PK_KONTS;

    /** @var string */
    public $ADRESE;

    /** @var int */
    public $PK_UDFORMA;

    /** @var string */
    public $EPASTS;

    public function rules()
    {
        return [
            ['KODS','string'],
            ['TIPS','string'],
            ['NOSAUK','string'],
            ['REG_NR','string'],
            ['PVN_REGNR','string'],
            ['PK_VALSTS','integer'],
            ['PK_KONTS','integer'],
            ['ADRESE','string'],
            ['PK_UDFORMA','integer'],
            ['EPASTS','email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function modelName(): string
    {
        // atgiezj xsd
        //return 'TDdmCustomerKred';

        /**
         * neatkozj XML -
         * vendor/yiisoft/yii2-httpclient/src/XmlParser.php:33
         * vendor\yiisoft\yii2-httpclient\src\Response.php:33
         * japieliek savs parseris. skatit
         * vendor/yiisoft/yii2-httpclient/src/Client.php:176
         */
        //return 'TDdmKredSar/query';

        return 'TDdmCustomer/8';
    }

    public static function primaryKey(): array
    {
        return ['id'];
    }
}

