<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;
use yii\base\Exception;


/**
 *
 * Norakstīšanas pavadzīme
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmPvzWriteOff
 *
 *
 */
class TNdmPvzWriteOff extends ApiModel implements ApiActiveRecordInterface
{


    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
//                'PK_DOKT',
//                'PK_NOM',
//                'BAR_KODS',
//                'NOSAUK',
//                'BARTYPE',
//                'AKTIVS',
//                'PAMV_ID',
//                'PK_BARKODS',
            ]
        );
    }

//    public function rules(): array
//    {
//        return array_merge(
//            parent::rules(),
//            [
//                [['PK_DOKT','PAMV_ID','PK_BARKODS','PK_NOM','BARTYPE'], 'integer'],
//                ['BAR_KODS', 'string', 'max' => 30],
//                ['NOSAUK', 'string', 'max' => 60],
//                ['AKTIVS', 'in', 'range' => [0,1]],
//            ]
//        );
//    }

    public static function apiRequestQuery(): string
    {
        throw new Exception('TNdmPvzWriteOff/query not exist');
    }

    public static function apiRequest(): string
    {
        return 'TNdmPvzWriteOff';
    }

    public static function apiRequestRecord(): string
    {
        return 'TNdmPvzWriteOff';
    }

    public static function primaryKey(): array
    {
        return ['PK_BARKODS'];
    }

    public static function apiRequestInsert(): string
    {
        return 'TNdmPvzWriteOff/template/2';
    }

    public static function apiTableQueryPrefix(): string
    {
        return 'NBR';
    }

    public static function prefixFieldSeparator(): string
    {
        return '_';
    }

    public function getDefault()
    {
        throw new Exception('Default not exist');
    }


}