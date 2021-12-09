<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ActiveRecord;

/**
 *
 * @property string $KODS
 * @property string $NOSAUK
 * @property integer $PK_NOMGR
 * @property integer $PK_GRUPA
 * @property integer $COUNTER
 * @property stting $STATUSS
 * @property string $Size10StringType
 * @property string $Size200StringType
 * @property string $Size400StringType
 */
class NomenklaturaGrupa extends ActiveRecord
{

    public function rules()
    {
        return [
            ['KODS','string'. 'max' => 10],
            ['NOSAUK','string','max' => 200],
            ['PK_NOMGR','integer'],
            ['PK_GRUPA','integer'],
            ['COUNTER','integer'],
            ['Size10StringType','string', 'max' => 10],
            ['Size200StringType','string', 'max' => 200],
            ['Size400StringType','string', 'max' => 400],
        ];
    }

    public function attributeLabels()
    {
        return [
            'KODS' => 'Kods',
            'NOSAUK' => 'Nosaukums',
            'PK_NOMGR' => 'Nomenklatūras grupa',
            'PK_GRUPA' => 'Virsgrupa',
            'STATUSS' => 'Statuss',
        ];
    }

    public function attributes(): array
    {
        return [
            'PK_DOKT',
            'KODS',
            'TIPS',
            'NOSAUK',
            'REG_NR',
            'PVN_REGNR',
            'REG_DAT',
            'PK_VALSTS',
            'PK_KONTS',
            'ADRESE',
            'PK_UDFORMA',
            'EPASTS',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function modelName(): string
    {
        return 'TNdmNomGrSar';
    }

    public static function primaryKey(): array
    {
        return ['id'];
    }
}

