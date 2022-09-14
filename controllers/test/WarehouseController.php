<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\Warehouse;
use d3yii2\d3horizon\Module;
use yii\console\ExitCode;
use d3yii2\d3horizon\models\Creditor;

/**
* Class WarehouseController* @property Module $module
*/
class WarehouseController extends D3CommandController
{
    /**
     * default action
     * nestraadaa
     * @return int
     *
     */
    public function actionIndex()
    {
        /** @var simialbi\yii2\rest\ActiveRecord $res */
        $res = Warehouse::find()->one();
        
        print_r($res->getAttributes());
    }
}

