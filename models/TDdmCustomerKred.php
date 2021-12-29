<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\components\TdmDocType;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;


/**
 *
 * Kreditoru saraksts(TDdmKredSar)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TDdmCustomer
 *
 * @property integer $PK_DOKT
 * @property integer $PAMV_ID
 * @property integer $PK_KLIENTSM
 * @property string $KODS
 * @property integer $TIPS
 * @property integer $STATUSS
 * @property string $NOSAUK
 * @property string $REG_NR
 * @property string $REG_DAT
 * @property string $PVN_REGNR
 * @property integer $REZIDENTS
 * @property string $ADRESE
 * @property string $EPASTS
 * @property string $WWWLAPA
 * @property string $TELEFONS
 *
 */
class TDdmCustomerKred extends ApiModel implements ApiActiveRecordInterface
{

    public function init()
    {
        parent::init();
        $this->PK_DOKT = TdmDocType::KD_KLIENTS;
    }

    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'PK_DOKT',
                'PAMV_ID',
                'COUNTER',
                'KODS',
                'NOSAUK',
                'PK_KLIENTSM',
                'TIPS',
                'REG_NR',
                'REG_DAT',
                'PVN_REGNR',
                'REZIDENTS',
                'ADRESE',
                'EPASTS',
                'WWWLAPA',
                'TELEFONS',
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['PK_DOKT', 'integer'],
                ['PAMV_ID', 'integer'],
                ['COUNTER', 'integer'],
                ['KODS', 'string', 'max' => 18],
                ['NOSAUK', 'string', 'max' => 100],
                ['STATUSS', 'integer'],
                ['REZIDENTS', 'integer'],
                ['TIPS', 'integer'],
            ]
        );
    }

    public static function apiRequestQuery(): string
    {
        return 'TDdmKredSar/query';
    }

    public static function apiRequest(): string
    {
        return 'TDdmCustomer';
    }

    public static function primaryKey(): array
    {
        return ['PK_KLIENTSM'];
    }

    public static function apiRequestInsert(): string
    {
        // not implemented
    }

    public static function apiTableQueryPrefix(): string
    {
        return 'K';
    }

}