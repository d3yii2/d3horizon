<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\TdmNRecRows1;
use d3yii2\d3horizon\models\TNdmRecept;
use d3yii2\d3horizon\models\TNdmRecSar;
use d3yii2\d3horizon\Module;
use yii\helpers\Json;
use yii\helpers\VarDumper;


/**
* Class CreditorsController* @property Module $module
*/
class RecRows1Controller extends D3CommandController
{


    /** straadaa */
    public function actionDescription()
    {
        $model = new TdmNRecRows1();
        echo VarDumper::dumpAsString($model->getDescription());
    }

    /** straadaa */
    public function actionDescriptionDetailed()
    {
        $model = new TdmNRecRows1();
        echo VarDumper::dumpAsString($model->getDescriptionDetailed());
    }

    /** straadaa */
    public function actionXsd()
    {
        $model = new TdmNRecRows1();
        echo VarDumper::dumpAsString($model->getXsd());
    }



    /** straadaa */
    public function actionExperiments()
    {
//        $model = new TNdmRecSar();
//        echo VarDumper::dumpAsString(Json::decode($model->getDtata('GET', 'TNdmRecSar/default')));
//        $r = TNdmRecSar::findOne(['KODS' => 'KAV1']);
        $r = TdmNRecRows1::findOne(['PK_NOM' => 310]);
        echo VarDumper::dumpAsString($r->attributes);
    }

}

