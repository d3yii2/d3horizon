<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ActiveRecord;
use d3yii2\d3horizon\components\TdmDocType;

/**
 *
 * @property integer $id
 * @property integer $PK_DOKT
 * @property integer $PAMVID
 * @property integer $COUNTER
 * @property string $PK_NOM
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
class TNdmNom extends ActiveRecord
{

    public function init()
    {
        parent::init();
        $this->PK_DOKT = TdmDocType::NNMK_NOMENKLATURA;
    }

    public function rules()
    {
        return [
            ['id','integer'],
            ['PK_DOKT','integer'],
            ['PAMVID','integer'],
            ['COUNTER','integer'],
            ['KODS','string', 'max' => 10],
            ['NOSAUK','string','max' => 200],
            ['PK_NOMGR','integer'],
            ['PK_LIKME','integer'],
            ['PK_DNORGRP','integer'],
            ['STATUSS','integer'],
            ['COUNTER','integer'],
//            ['Size10StringType','string', 'max' => 10],
//            ['Size200StringType','string', 'max' => 200],
//            ['Size400StringType','string', 'max' => 400],
            ['VIEN_KODS','string', 'max' => 5],
            ['VIEN_NOSAUK','string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'PK_DOKT' => 'Dokumenta tips',
            'COUNTER' => 'COUNTER',
            'KODS' => 'Kods',
            'NOSAUK' => 'Nosaukums',
            'PK_NOMGR' => 'Nomenklatūras grupa',
            'STATUSS' => 'Statuss',
            'PK_LIKME' => 'PVN Likme',
            'PK_DNORGRP' => 'Norēķinu grupa',
        ];
    }

    public function attributes(): array
    {
        return [
            'id',
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
            'VIEN_KODS',
            'VIEN_NOSAUK',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function modelName(): string
    {
        //return 'TNdmNom';
        return 'TNdmNomIzvSar';
    }

    public static function primaryKey(): array
    {
        return ['id'];
    }



}

