<?php

namespace d3yii2\d3horizon\models;

use yii\db\BaseActiveRecord;


/**
 *
 * Receptes(TNdmRecSar) rindas - sarazjota produkcija
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmRecSar
 *
 * @property integer $RN_VEIDS veids enum
 * @property integer $PK_NOM nomenklatura
 * @property integer $RAZ_VEIDS  recepte
 * @property integer $DAUDZ daudzums
 * @property integer $PK_NOL Noliktava
 * @property float $SUMMA SUMMA
 * @property float $SUMMA_IEP2V Iepirkuma summa
 * @property float $SUMMA_STAT2V Iepirkuma summa
 *
 */
class tblRindasR extends BaseActiveRecord
{

    public const RN_VEIDS_NOMENKLATURA = 0;
    public const RN_VEIDS_PAKALPOJUMS = 3;
    public const RN_VEIDS_TEKSTS = 1;


    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'RN_VEIDS',
                'PK_NOM',
                'RAZ_VEIDS',
                'DAUDZ',
                'PK_NOL',
                'SUMMA',
                'SUMMA_IEP2V',
                'SUMMA_STAT2V'
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['RN_VEIDS','PK_NOM','RAZ_VEIDS','DAUDZ','PK_NOL'], 'integer'],
                [['SUMMA','SUMMA_IEP2V','SUMMA_STAT2V'],'number']
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
