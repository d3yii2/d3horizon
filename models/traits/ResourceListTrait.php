<?php

namespace d3yii2\d3horizon\models\traits;

use simialbi\yii2\rest\ActiveRecord;

trait ResourceListTrait
{
    public function rules()
    {
        return [
            ['description', 'string'],
            [['description', 'link'], 'safe'],
        ];
    }
    
    
    public function attributes(): array
    {
        return [
            'id',
            'description',
            'link',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function primaryKey(): array
    {
        return ['id'];
    }
}

