<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\components\TdmDocType;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;

/**
 *
 * Pavadzimes(TNdmPvzIn)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmPvzIn
 *
 * @property integer $PK_DOKT
 * @property integer $PK_DOK
 * @property integer $PAMV_ID
 * @property string $DAT_DOK
 * @property string $DAT_GRAM
 * @property string $DOK_NR
 * @property integer $SUMMA
 * @property integer $VIRZIENS
 * @property integer $TIPS
 * @property integer $SUMMA_PV
 * @property integer $SUMMA_APM
 * @property integer $SUMMA_APMP
 * @property integer $SUMMA_APMN
 * @property integer $SUMMA_SAM
 * @property integer $SUMMA_PVN_REV
 * @property integer $SUMMA_PVN
 * @property integer $DOK_PVN
 * @property integer $SUM_PAPM
 * @property string $DOK_SERIJA
 * @property string $DOK_REGNR
 */
class TNdmPvzIn extends ApiModel implements ApiActiveRecordInterface
{

    public function init()
    {
        parent::init();
        $this->PK_DOKT = TdmDocType::PAVADZIME;
    }

    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'PK_DOKT',
                'PK_DOK',
                'COUNTER',
                'PAMV_ID',
                'DAT_DOK',
                'DAT_GRAM',
                'DOK_NR',
                'SUMMA',
                'VIRZIENS',
                'TIPS',
                'SUMMA_PV',
                'SUMMA_APM',
                'SUMMA_APMP',
                'SUMMA_APMN',
                'SUMMA_SAM',
                'SUMMA_PVN_REV',
                'SUMMA_PVN',
                'DOK_PVN',
                'SUM_PAPM',
                'DOK_SERIJA',
                'DOK_REGNR',
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['PK_DOKT', 'integer'],
                ['PK_DOK', 'integer'],
                ['COUNTER', 'integer'],
                ['PAMV_ID', 'integer'],
                ['SUMMA', 'integer'],
                ['VIRZIENS', 'integer'],
                ['TIPS', 'integer'],
                ['SUMMA_PV', 'integer'],
                ['SUMMA_APM', 'integer'],
                ['SUMMA_APMP', 'integer'],
                ['SUMMA_APMN', 'integer'],
                ['SUMMA_SAM', 'integer'],
                ['SUMMA_PVN_REV', 'integer'],
                ['SUMMA_PVN', 'integer'],
                ['SUMMA_SAM', 'integer'],
                ['DOK_PVN', 'integer'],
                ['SUM_PAPM', 'integer'],
            ]
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'PK_DOKT' => 'Dokumenta tips',
            ]
        );
    }

    public static function apiRequestQuery(): string
    {
        return 'TNdmPvzInSar/query';
    }

    public static function apiRequest(): string
    {
        return 'TNdmPvzIn';
    }

    public static function apiRequestInsert(): string
    {
        return 'TNdmPvzIn/template/6';
    }

    public static function primaryKey(): array
    {
        return ['PK_DOK'];
    }

    public static function apiTableQueryPrefix(): string
    {
        return 'D';
    }
}
