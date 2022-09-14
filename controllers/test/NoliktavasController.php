<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\TNdmNolSar;
use d3yii2\d3horizon\models\TNdmPvzRaz;
use d3yii2\d3horizon\models\TNdmRecSar;
use d3yii2\d3horizon\Module;
use yii\helpers\Json;
use yii\helpers\VarDumper;



class NoliktavasController extends D3CommandController
{


    /** straadaa */
    public function actionDescription()
    {
        $model = new TNdmNolSar();
        echo VarDumper::dumpAsString($model->getDescription());
    }

    /** straadaa */
    public function actionDescriptionDetailed()
    {
        $model = new TNdmNolSar();
        echo VarDumper::dumpAsString($model->getDescriptionDetailed());
    }

    /** straadaa */
    public function actionIndexDefault()
    {
        $model = new TNdmNolSar();
        echo VarDumper::dumpAsString(Json::decode($model->getDtata('GET', 'TNdmNolSar/default')));

    }

    /** straadaa */
    public function actionFindOne(int $id)
    {
        $r = TNdmNolSar::findOne(['KODS' =>'001']);
        echo VarDumper::dumpAsString($r);
    }

    /** straadaa */
    public function actionSync()
    {
        $model = new TNdmRecSar();
        echo VarDumper::dumpAsString(Json::decode($model->getDtata('GET', 'TNdmRecSar/sync')));
    }

    public function actionTemplatesList(): void
    {
        $model = new TNdmPvzRaz();
        echo VarDumper::dumpAsString(Json::decode($model->getDtata('GET', 'TNdmPvzRaz/template')));
    }

    /**
     *  ERROR 'Nav ievadīts valūtas  kurss 05.01.1993.!'
     * @param int $id
     * @return void
     */
    public function actionTemplate(int $id = 37): void
    {
        $model = new TNdmPvzRaz();
        echo VarDumper::dumpAsString(Json::decode($model->getDtata('GET', 'TNdmPvzRaz/template/' . $id)));
    }

    public function actionWadl(): void
    {
        $model = new TNdmPvzRaz();
        echo VarDumper::dumpAsString($model->getDtata('GET', 'TNdmPvzRaz/TNdmPvzRaz.wadl'));
    }

    public function actionXsd(): void
    {
        $model = new TNdmPvzRaz();
        echo VarDumper::dumpAsString($model->getDtata('GET', 'TNdmPvzRaz/TNdmPvzRaz.xsd'));
    }

    public function actionXxx(): void
    {
        $model = new TNdmPvzRaz();
        echo VarDumper::dumpAsString($model->getDtata('POST', 'TNdmPvzRaz/doRegisterBLEvent'));
    }

}

