<?php

namespace d3yii2\d3horizon\models;

use yii\db\BaseActiveRecord;


/**
 *
 * Receptes(TNdmRecSar)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmRecSar
 *
 * @property integer $RN
 * @property integer $NPK
 * @property integer $RN_VEIDS veids enum
 * @property integer $PK_NOM nomenklatura
 * @property string $KODS
 * @property integer $PK_V1 mervieniba 1
 * @property integer $PK_V2 mervieniba 2
 * @property integer $PK_V3 mervieniba 3
 * @property integer $PK_VIEN mervieniba
 * @property string $V_KODS mervieniba
 * @property integer $RAZ_VEIDS  recepte
 * @property integer $DAUDZ
 * @property float $SVARS
 * @property integer $PK_NOL
 * @property float $DAUDZ11
 * @property float $DAUDZ12
 * @property float $DAUDZ13
 *
 */
class tblRindas extends BaseActiveRecord
{

    public const RN_VEIDS_NOMENKLATURA = 0;
    public const RN_VEIDS_PAKALPOJUMS = 3;
    public const RN_VEIDS_TEKSTS = 1;

    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'NPK',
                'RN',
                'RN_VEIDS',
                'PK_NOM',
                'KODS',
                'PK_V1','PK_V2','PK_V3','PK_VIEN',
                'V_KODS',
                'DAUDZ11','DAUDZ12','DAUDZ13',
                'RAZ_VEIDS',
                'DAUDZ',
                'PK_NOL',
                'SVARS'

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
                        'RN_VEIDS','PK_NOM','RAZ_VEIDS','DAUDZ','PK_NOL','RN',
                        'NPK',
                        'PK_V1','PK_V2','PK_V3','PK_VIEN'
                    ],
                    'integer'
                ],
                [
                    ['KODS','V_KODS'],
                    'string'
                ],
                [['SVARS','DAUDZ11','DAUDZ12','DAUDZ13'],'number']
            ]
        );
    }

    public static function primaryKey()
    {
        // TODO: Implement primaryKey() method.
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
