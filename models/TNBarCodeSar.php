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
class TNBarCodeSar extends ApiModel implements ApiActiveRecordInterface
{


    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'PK_DOKT',
                'PAMV_ID',
                'PK_BARKODS',
                'PK_NOM',
                'BAR_KODS',
                'NOSAUK',
                'BARTYPE',
                'AKTIVS'
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
        return 'TNBarCodeSar/query';
    }

    public static function apiRequest(): string
    {
        return 'TNBarCodeSar';
    }

    public static function apiRequestRecord(): string
    {
        return 'TNBarCodeSar';
    }

    public static function primaryKey(): array
    {
        return ['PK_BARKODS'];
    }

    public static function apiTableQueryPrefix(): string
    {
        return 'NBR';
    }

    public static function prefixFieldSeparator(): string
    {
        return '.';
    }

    public function isAkctivs()
    {
        return $this->AKTIVS === 1;
    }

    public function isNeakctivs()
    {
        return $this->AKTIVS !== 1;
    }


    /**
     * @param string $barCode
     * @return $this|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \simialbi\yii2\rest\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\httpclient\Exception
     */
    public static function findByCode(string $barCode): ?self
    {
        return self::findOne(['BAR_KODS' => $barCode]);
    }

    public static function apiRequestInsert(): string
    {
        throw new Exception('Insert no implemented');
    }
}