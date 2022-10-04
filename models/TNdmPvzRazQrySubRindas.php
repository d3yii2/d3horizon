<?php

namespace d3yii2\d3horizon\models;

use yii\base\Exception;
use yii\db\BaseActiveRecord;


/**
 *
 * Ražošanas pavadzīme(TNdmPvzRaz)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmPvzRaz
 *
 * @property integer $RN Rindas numurs
 * @property integer $PK_NOMPART
 * @property float $DAUDZ Pavadzīme
 *
 */
class TNdmPvzRazQrySubRindas extends BaseActiveRecord
{

    public function attributes(): array
    {
        return array_merge(
            parent::attributes(),
            [
                'RN',
                'PK_NOMPART',
                'DAUDZ',
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'RN','PK_NOMPART','DAUDZ',
                    ],
                    'integer'
                ],
            ]
        );
    }

    public static function apiRequestQuery(): string
    {
        throw new Exception('Query not exist');
    }

    public static function apiRequest(): string
    {
        throw new Exception('apiRequest');
    }

    public static function apiRequestRecord(): string
    {
        throw new Exception('apiRequestRecord');
    }

    public static function primaryKey(): array
    {
        return [''];
    }

    public static function apiRequestInsert(): string
    {
        throw new Exception('apiRequestInsert');
    }

    public static function apiTableQueryPrefix(): string
    {
        throw new Exception('apiTableQueryPrefix');
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