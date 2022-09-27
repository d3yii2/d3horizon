<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\TNBarCodeSar;
use d3yii2\d3horizon\models\TNdmBarCode;
use d3yii2\d3horizon\models\TNdmNom;
use d3yii2\d3horizon\models\TNdmPvzRaz;
use d3yii2\d3horizon\models\TNdmRecSar;
use d3yii2\d3horizon\Module;
use yii\helpers\Json;
use yii\helpers\VarDumper;


/**
* Class CreditorsController* @property Module $module
*/
class BarCodeController extends D3CommandController
{


    /** straadaa */
    public function actionDescription()
    {
        $model = new TNdmBarCode();
        echo VarDumper::dumpAsString($model->getDescription());
    }

    /** straadaa */
    public function actionDescriptionDetailed()
    {
        $model = new TNdmBarCode();
        echo VarDumper::dumpAsString($model->getDescriptionDetailed());
    }


    public function actionCriteria()
    {
        $model = new TNdmBarCode();
        echo VarDumper::dumpAsString(Json::decode($model->getDtata('GET', 'TNdmRecSar/criteria')));
    }

    public function actionQuery()
    {
        $model = new TNdmBarCode();
        echo VarDumper::dumpAsString(Json::decode($model->getDtata(
            'GET',
            //'TNdmRecSar/query?columns=R.COUNTER%2CR.KODS%2CR.NOSAUK%2CR.PK_REC&filter=%28R.PK_REC+eq+9%29&limit=1'
            //'TNBarCodeSar/query?columns=R_COUNTER%2CR_KODS%2CR_NOSAUK%2CR.PK_REC&filter=%28R.KODS+eq+2222/0%29&limit=1'
            'TNBarCodeSar/query?columns=NBR.COUNTER%2CNBR.PK_DOKT%2CNBR.PAMV_ID%2CNBR.PK_BARKODS%2CNBR.PK_NOM%2CNBR.BAR_KODS%2CNBR.NOSAUK%2CNBR.BARTYPE%2CNBR.AKTIVS&filter=%28NBR.BAR_KODS+eq+123123123%29&limit=1'
        )));
    }

    public function actionWadl(): void
    {
        $model = new TNdmBarCode();
        echo VarDumper::dumpAsString($model->getWadl());
    }

    public function actionXsd(): void
    {
        $model = new TNdmBarCode();
        echo VarDumper::dumpAsString($model->getXsd());
    }
}

