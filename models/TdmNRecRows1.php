<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;
use yii\base\Model;


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
 *
 */
class TdmNRecRows1 extends Model
{

    public const RN_VEIDS_NOMENKLATURA = 0;

    public $PK_RECP;
    public $PK_REC;
    public $RN_VEIDS;
    public $PK_NOL;
    public $PK_NOM;
    public $N_BAR_KODS;


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
                'N_BAR_KODS'
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['PK_RECP','PK_REC','RN_VEIDS','PK_NOM'], 'integer'],
                ['N_BAR_KODS','string','max' => 30]
            ]
        );
    }
}
