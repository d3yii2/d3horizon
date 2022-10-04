<?php

namespace d3yii2\d3horizon\models;

use yii\db\BaseActiveRecord;


/**
 *
 * Receptes(TNdmRecSar)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmRecSar
 *
 * @property integer $PK_RECP
 * @property integer $PK_REC  recepte
 * @property integer $RN_VEIDS veids enum
 * @property integer $PK_NOL noliktava
 * @property integer $PK_NOM nomenklatura
 * @property string $N_BAR_KODS
 * @property integer $DAUDZ
 *
 */
class TdmNRecRows extends BaseActiveRecord
{

    public const RN_VEIDS_NOMENKLATURA = 0;

    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'PK_RECP',
                'PK_REC',
                'RN_VEIDS',
                'PK_NOL',
                'PK_NOM',
                'N_BAR_KODS',
                'DAUDZ'
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['PK_RECP','PK_REC','RN_VEIDS','PK_NOM','DAUDZ'], 'integer'],
                ['N_BAR_KODS','string','max' => 30]
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
