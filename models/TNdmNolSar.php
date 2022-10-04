<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;


/**
 *
 * Noliktavas(TNdmPvzRaz)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmNolSar
 *
 * @property integer $PK_REC
 * @property string $KODS
 * @property string $NOSAUK
 *
 */
class TNdmNolSar extends ApiModel implements ApiActiveRecordInterface
{

//    public function init()
//    {
//        parent::init();
//        $this->PK_DOKT = TdmDocType::KD_KLIENTS;
//    }

    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'KODS',
                'NOSAUK',
                //'PK_REC',
                'ADRESE',
                'PK_KLIENTS',
                'ATLCHECK'
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['KODS', 'string', 'max' => 12],
                ['NOSAUK', 'string', 'max' => 35],
                ['ADRESE', 'string', 'max' => 47],
                ['ATLCHECK', 'integer'],
                ['PK_KLIENTS', 'integer'],
                //['PK_REC', 'integer'],
            ]
        );
    }

    public static function apiRequestQuery(): string
    {
        return 'TNdmNolSar/query';
    }

    public static function apiRequest(): string
    {
        return 'TNdmNolSar';
    }

    public static function apiRequestRecord(): string
    {
        return 'TNdmNolSar/query';
    }

    public static function primaryKey(): array
    {
        return ['PK_REC'];
    }

    public static function apiRequestInsert(): string
    {
        return 'TNdmNolSar/template/2';
    }

    public static function apiTableQueryPrefix(): string
    {
        return 'NOL';
    }

}