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
 * @property integer $PAMV_ID
 * @property integer $PK_BARKODS TNdmBarCode:TNdmBarCodeForeignKeyStructure
 * @property integer $PK_NOM Nomenklatūra TNdmNom:TNdmNomForeignKeyStructure
 * @property string $BAR_KODS
 * @property string $NOSAUK
 * @property string $BARTYPE svītrkoda tips TNdmBarCodeBARTYPEType
 * @property integer $AKTIVS
 *
 */
class TNdmBarCode extends ApiModel implements ApiActiveRecordInterface
{


    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'PK_DOKT',
                'PK_NOM',
                'BAR_KODS',
                'NOSAUK',
                'BARTYPE',
                'AKTIVS',
                'PAMV_ID',
                'PK_BARKODS',
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['PK_DOKT','PAMV_ID','PK_BARKODS','PK_NOM','BARTYPE'], 'integer'],
                ['BAR_KODS', 'string', 'max' => 30],
                ['NOSAUK', 'string', 'max' => 60],
                ['AKTIVS', 'in', 'range' => [0,1]],
            ]
        );
    }

    public static function apiRequestQuery(): string
    {
        return 'TNdmBarCode/query';
    }

    public static function apiRequest(): string
    {
        return 'TNdmBarCode';
    }

    public static function apiRequestRecord(): string
    {
        return 'TNdmBarCode';
    }

    public static function primaryKey(): array
    {
        return ['PK_BARKODS'];
    }

    public static function apiRequestInsert(): string
    {
        return 'TDdmCustomer/template/2';
    }

    public static function apiTableQueryPrefix(): string
    {
        return 'NBR';
    }

    public static function prefixFieldSeparator(): string
    {
        return '.';
    }




    public function getDefault()
    {
        throw new Exception('Default not exist');
    }


}