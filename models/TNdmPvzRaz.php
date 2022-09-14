<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;


/**
 *
 * Ražošanas pavadzīme(TNdmPvzRaz)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmPvzRaz
 *
 * @property integer $PK_REC
 * @property string $KODS
 * @property string $NOSAUK
 *
 */
class TNdmPvzRaz extends ApiModel implements ApiActiveRecordInterface
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
                'PK_REC',
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['KODS', 'string', 'max' => 15],
                ['NOSAUK', 'string', 'max' => 50],
                ['PK_REC', 'integer'],
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