<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\components\TdmDocType;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;

/**
 *
 * Nomenklatūra(TNdmNom)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmNom
 *
 * @property integer $PK_DOKT
 * @property integer $PAMVID
 * @property integer $PK_NOM
 * @property string $KODS
 * @property string $NOSAUK
 * @property integer $PK_RAZOT
 * @property string $SERTIFS
 * @property integer $PK_NOMGR
 * @property integer $PK_VIEN
 * @property integer $PK_LIKME
 * @property integer $PK_DNORGRP
 * @property float $SVARS
 * @property float $BRUTO
 * @property stting $NOSAUKSV
 * @property stting $KAT_KODS
 * @property string $FILENAME
 * @property int $PK_NOMKAT
 * @property string $BAR_KODS
 * @property integer $STATUSS
 * @property float $GAR
 * @property float $PLAT
 * @property float $AUGST
 * @property float $VIEN_KODS
 * @property float VIEN_NOSAUK
 *
 *
 */
class TNdmNom extends ApiModel implements ApiActiveRecordInterface
{

    public function init()
    {
        parent::init();
        $this->PK_DOKT = TdmDocType::NNMK_NOMENKLATURA;
    }

    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'PK_DOKT',
                'PAMVID',
                'COUNTER',
                'PK_NOM',
                'KODS',
                'NOSAUK',
                'PK_RAZOT',
                'PK_LIKME',
                'PK_DNORGRP',
                'SERTIFS',
                'PK_NOMGR',
                'PK_VIEN',
                'SVARS',
                'BRUTO',
                'NOSAUKSV',
                'KAT_KODS',
                'FILENAME',
                'PK_NOMKAT',
                'BAR_KODS',
                'STATUSS',
                'GAR',
                'PLAT',
                'AUGST',
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['PK_DOKT', 'integer'],
                ['PAMVID', 'integer'],
                ['COUNTER', 'integer'],
                ['KODS', 'string', 'max' => 10],
                ['NOSAUK', 'string', 'max' => 200],
                ['PK_NOM', 'integer'],
                ['PK_NOMGR', 'integer'],
                ['PK_LIKME', 'integer'],
                ['PK_DNORGRP', 'integer'],
                ['STATUSS', 'integer'],
                ['COUNTER', 'integer'],
            ]
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'PK_DOKT' => 'Dokumenta tips',
                'COUNTER' => 'COUNTER',
                'KODS' => 'Kods',
                'NOSAUK' => 'Nosaukums',
                'PK_NOMGR' => 'Nomenklatūras grupa',
                'STATUSS' => 'Statuss',
                'PK_LIKME' => 'PVN Likme',
                'PK_DNORGRP' => 'Norēķinu grupa',
            ]
        );
    }

    public static function apiRequestQuery(): string
    {
        return 'TNdmNomIzvSar/query';
    }

    public static function apiRequest(): string
    {
        return 'TNdmNom';
    }

    public static function apiRequestInsert(): string
    {
        return 'TNdmNom/template/3';
    }

    public static function primaryKey(): array
    {
        return ['PK_NOM'];
    }

    public static function apiTableQueryPrefix(): string
    {
        return 'N';
    }
}
