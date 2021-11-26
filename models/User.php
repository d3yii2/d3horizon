<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\models\traits\ResourceListTrait;
use simialbi\yii2\rest\ActiveRecord;

class User extends ActiveRecord
{
    use ResourceListTrait;
    
    /**
     * {@inheritdoc}
     */
    public static function modelName(): string
    {
        return 'user';
    }
}

