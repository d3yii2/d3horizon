<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\Module;
use yii\console\ExitCode;
use d3yii2\d3horizon\models\Creditor;

/**
* Class CreditorsController* @property Module $module
*/
class CreditorController extends D3CommandController
{
    /**
     * default action
     * @return int
     */
    public function actionIndex()
    {
        /** @var simialbi\yii2\rest\ActiveRecord $res */
        $res = Creditor::find()->one();
        
        print_r($res->getAttributes());
    }
}

