<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;
use yii\base\Exception;


/**
 *
 * Kontējumu shēma
 * @link https://horizon-rest-doc.visma.lv/en/ApiDoc?ServiceCode=TdmBLKontShema
 *
 * @property integer $PK_SHEMA
 * @property integer $PK_FIRMA
 * @property integer $DOC_ID Dokuments TdmBLKontShemaDOC_IDType
 * @property string $KODS
 * @property string $NOSAUK
 * @property integer $TIPS
 * @property string $PIEZ
 *
 */
class TdmBLKontShema extends ApiModel implements ApiActiveRecordInterface
{
    public const DOC_RAZOSANAS_PAVADZIME = 2718;

    public function attributes(): array
    {
        return array_merge(
            parent::attributes(),
            [
                'PK_SHEMA',
                'PK_FIRMA',
                'DOC_ID',
                'KODS',
                'NOSAUK',
                'TIPS',
                'PIEZ',
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['PK_SHEMA','PK_FIRMA','DOC_ID','TIPS'], 'integer'],
                ['KODS', 'string', 'max' => 10],
                ['NOSAUK', 'string', 'max' => 60],
                ['PIEZ', 'string', 'max' => 100],

            ]
        );
    }

    public static function apiRequestQuery(): string
    {
        throw new Exception('TdmBLKontShema/query not exist');
    }

    public static function apiRequest(): string
    {
        return 'TdmBLKontShema';
    }

    public static function apiRequestRecord(): string
    {
        return 'TdmBLKontShema';
    }

    public static function primaryKey(): array
    {
        return ['PK_SHEMA'];
    }

    public static function apiRequestInsert(): string
    {
        return 'TdmNumerator/template/2';
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

    public function isDocRazosanasPavadzime(): bool
    {
        return $this->DOC_ID === self::DOC_RAZOSANAS_PAVADZIME;
    }
}
