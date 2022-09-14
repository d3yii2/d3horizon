<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\Invoice;
use d3yii2\d3horizon\Module;
use yii\console\ExitCode;

/**
* Class InvoiceController* @property Module $module
*/
class InvoiceController extends D3CommandController
{
    /**
     * nestraadaa
     * default action
     * @return int
     */
    public function actionIndex()
    {
        /** @var \simialbi\yii2\rest\ActiveRecord $res */
        $res = Invoice::find()->one();
        
        print_r($res->getAttributes());
    }
}

