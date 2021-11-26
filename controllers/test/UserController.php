<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\components\HorizonApi;
use d3yii2\d3horizon\models\User;
use d3yii2\d3horizon\Module;
use yii\console\ExitCode;

/**
* Class UserController* @property Module $module
*/
class UserController extends D3CommandController
{
    /**
     * default action
     * @return int
     */
    public function actionIndex()
    {
        /** @var simialbi\yii2\rest\ActiveRecord $res */
        $res = User::find()->one();
        
        print_r($res->getAttributes());
    }
}

