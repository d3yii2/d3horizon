<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\TNdmRecSar;
use d3yii2\d3horizon\Module;
use yii\helpers\Json;
use yii\helpers\VarDumper;


/**
* Class CreditorsController* @property Module $module
*/
class RecSarController extends D3CommandController
{


    /** straadaa */
    public function actionDescription()
    {
        $model = new TNdmRecSar();
        echo VarDumper::dumpAsString($model->getDescription());
    }

    /** straadaa */
    public function actionDescriptionDetailed()
    {
        $model = new TNdmRecSar();
        echo VarDumper::dumpAsString($model->getDescriptionDetailed());
    }

    /** straadaa */
    public function actionXsd()
    {
        $model = new TNdmRecSar();
        echo VarDumper::dumpAsString($model->getXsd());
    }


    public function actionIndexDefault()
    {
        $model = new TNdmRecSar();
        echo VarDumper::dumpAsString(Json::decode($model->getDefault()));
    }


    /** straadaa */
    public function actionExperiments()
    {
//        $model = new TNdmRecSar();
//        echo VarDumper::dumpAsString(Json::decode($model->getDtata('GET', 'TNdmRecSar/default')));
//        $r = TNdmRecSar::findOne(['KODS' => 'KAV1']);
        $r = TNdmRecSar::findOne(3);
        VarDumper::dumpAsString($r);
    }

    /** straadaa */
    public function actionSync()
    {
        $model = new TNdmRecSar();
        echo VarDumper::dumpAsString(Json::decode($model->getDtata('GET', 'TNdmRecSar/sync')));
    }


}

