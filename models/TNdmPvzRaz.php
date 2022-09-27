<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;


/**
 *
 * Ražošanas pavadzīme(TNdmPvzRaz)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmPvzRaz
 *
 * @property integer $PK_DOKT Dokumenta tips
 * @property integer $PAMV_ID Dokumenta veids
 * @property integer $PK_DOK Pavadzīme
 * @property integer $PK_IESTADE Iestāde
 * @property integer $STATUSS
 * @property integer $PK_ESPATS NOLIKTAVA
 * @property string $DAT_DOK dokumenta datums
 * @property int $PK_VAL valūta
 * @property string $DOK_NR Nummurs
 * @property int $TIPS Nummurs

 *
 */
class TNdmPvzRaz extends ApiModel implements ApiActiveRecordInterface
{

    public const STATUSS_APSTRADE = -2;
    public const STATUSS_GRAMATOTS = 3;
    public const STATUSS_IZPILDITS = 2;
    public const STATUSS_IZVEIDOTS = 0;
    public const STATUSS_SAGATAVE = 1;
    public const STATUSS_STORNETS = 4;

    public const TIPS_DOKUMENTS = 1;
    public const TIPS_REFORMACIJA = 5;
    public const TIPS_SAKUMA_ATLIKUMS = 2;

    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'PK_DOKT',
                'PAMV_ID',
                'PK_DOK',
                'PK_IESTADE',
                'STATUSS',
                'PK_ESPATS',
                'DAT_DOK',
                'PK_VAL',
                'DOK_NR',
                'TIPS'

            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['DAT_DOK', 'string', 'max' => 10],
                ['DOK_NR', 'string', 'max' => 25],
                [
                    [
                        'PK_DOKT','PAMV_ID','PK_DOK',
                        'PK_IESTADE','PK_ESPATS','PK_VAL',
                        'TIPS'
                    ],
                    'integer'
                ],
            ]
        );
    }

    public static function apiRequestQuery(): string
    {
        return 'TNdmRecSar/query';
    }

    public static function apiRequest(): string
    {
        return 'TNdmPvzRaz';
    }

    public static function apiRequestRecord(): string
    {
        return 'TNdmPvzRaz';
    }

    public static function primaryKey(): array
    {
        return ['PK_REC'];
    }

    public static function apiRequestInsert(): string
    {
        return 'TDdmCustomer/template/2';
    }

    public static function apiTableQueryPrefix(): string
    {
        return 'R';
    }

}