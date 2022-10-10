<?php

namespace d3yii2\d3horizon\models;

use yii\base\Exception;
use yii\db\BaseActiveRecord;


/**
 *
 * Ražošanas pavadzīme(TNdmPvzRaz)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmPvzRaz
 *
 * @property integer $RN Rindas numurs
 * @property integer $PK_NOMPART
 * @property float $DAUDZ Pavadzīme
 * @property int $PK_VOL Pavadzīme
 * @property string $NUMURS Oartija
 * @property int $PK_DOK
 * @property int $PK_NOL
 * @property string $DAT_TERM deriguma termins
 * @property string $SERTIFS sertifikats
 * @property string $NOL_KODS Noliktava
 * @property float $CENA_IEG Uzsk. cena, Ls
 * @property float $SUMMA Summa, Ls
 * @property int $STATUSS
 *
 */
class TNdmPvzRazQrySubRindas extends BaseActiveRecord
{
    public const STATUS_APSTRADE = -2;
    public const STATUS_GRAMATOTS = 3;
    public const STATUS_IZPILDITS = 2;
    public const STATUS_IZVEIDOTS = 0;
    public const STATUS_SAGATAVE = 1;
    public const STATUS_STORNETS = 4;

    public function attributes(): array
    {
        return array_merge(
            parent::attributes(),
            [
                'RN',
                'PK_NOMPART',
                'DAUDZ',
                'PK_VOL',
                'NUMURS',
                'PK_DOK',
                'PK_NOL',
                'DAT_TERM',
                'SERTIFS',
                'NOL_KODS',
                'CENA_IEG',
                'SUMMA',
                'STATUSS'
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'RN','PK_NOMPART','DAUDZ',
                        'PK_VOL','PK_DOK','PK_NOL',
                        'STATUSS'
                    ],
                    'integer'
                ],
                [['NUMURS','DAT_TERM','SERTIFS','NOL_KODS'],'string'],
                [['CENA_IEG'.'SUMMA'],'number']
            ]
        );
    }

    public static function apiRequestQuery(): string
    {
        throw new Exception('Query not exist');
    }

    public static function apiRequest(): string
    {
        throw new Exception('apiRequest');
    }

    public static function apiRequestRecord(): string
    {
        throw new Exception('apiRequestRecord');
    }

    public static function primaryKey(): array
    {
        return [''];
    }

    public static function apiRequestInsert(): string
    {
        throw new Exception('apiRequestInsert');
    }

    public static function apiTableQueryPrefix(): string
    {
        throw new Exception('apiTableQueryPrefix');
    }

    public static function find()
    {
        // TODO: Implement find() method.
    }

    public function insert($runValidation = true, $attributes = null)
    {
        // TODO: Implement insert() method.
    }

    public static function getDb()
    {
        // TODO: Implement getDb() method.
    }


}