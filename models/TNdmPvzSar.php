<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;
use yii\base\Exception;


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
 * @property int $PK_KLIENTS Cehs
 *
 * TNdmPvzSar_TNdmPvzSarAddition085Structure
 * @property float $KOP_SUMMA_IZIEP Cehs
 *
 */
class TNdmPvzSar extends ApiModel implements ApiActiveRecordInterface
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
    //const findAll = ;

    /** @var \d3yii2\d3horizon\models\tblRindas[] izejvielas */
    public $tblRindas = [];

    /** @var \d3yii2\d3horizon\models\tblRindasR[] Razjojamais */
    public $tblRindasR = [];

    /** @var \d3yii2\d3horizon\models\TNdmPvzRazQrySubRindas[] izmatotas partijas nomenklatura */
    public $qrySubRindas = [];

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
                'TIPS',
                'PK_KLIENTS',
                'KOP_SUMMA_IZIEP'
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
                        'TIPS', 'PK_KLIENTS'
                    ],
                    'integer'
                ],
                [['KOP_SUMMA_IZIEP'],'float']
            ]
        );
    }

    public static function vismaRelations(): array
    {
        return [
            'TNdmPvzSarAddition085' => [
                'parent' => 'D',
                'prefix' => 'KOP',
                'fields' => ['SUMMA_IZIEP']
            ],
        ];
    }

    public static function apiRequestQuery(): string
    {
        return 'TNdmPvzSar/query';
    }

    public static function apiRequest(): string
    {
        return 'TNdmPvzSar';
    }

    public static function apiRequestRecord(): string
    {
        return '';
    }

    public static function primaryKey(): array
    {
        return ['PK_DOK'];
    }

    public static function apiRequestInsert(): string
    {
        return 'TNdmPvzSar/template/37';
    }

    public static function apiTableQueryPrefix(): string
    {
        return 'D';
    }
}