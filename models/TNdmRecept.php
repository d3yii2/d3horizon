<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;


/**
 *
 * Receptes(TNdmRecSar)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmRecSar
 *
 * @property integer $PK_REC
 * @property string $KODS
 * @property string $NOSAUK
 *
 */
class TNdmRecept extends ApiModel implements ApiActiveRecordInterface
{

    /** @var \d3yii2\d3horizon\models\TdmNRecRows[] */
    public $dmNRecRows = [];

    /** @var \d3yii2\d3horizon\models\TdmNRecRows1[] */
    public $dmNRecRows1 = [];

    public static function relatedEntities()
    {
        return [
            [
                'entityName' => 'dmNRecRows',
                'entityModelClass' => TdmNRecRows::class
            ],
            [
                'entityName' => 'dmNRecRows1',
                'entityModelClass' => TdmNRecRows1::class
            ],
        ];
    }

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
        return 'TNdmRecept';
    }

    public static function apiRequestRecord(): string
    {
        return 'TNdmRecept';
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

    public static function findOneBySarazotasNomenklaturas(int $pkNom): ?TNdmRecept
    {
        foreach (self::findAll([]) as $recept) {
            /** @var self $receptesEntity */
            $receptesEntity = self::findOne($recept->PK_REC);
            foreach ($receptesEntity->dmNRecRows as $row) {
                if ((int)$row->PK_NOM === $pkNom) {
                    return $receptesEntity;
                }
            }
        }
        return null;
    }
}
