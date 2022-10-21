<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\TNdmPvzIn;
use yii\helpers\VarDumper;



class TNdmPvzInController extends D3CommandController
{


    /** straadaa */
    public function actionDescription()
    {
        $model = new TNdmPvzIn();
        echo VarDumper::dumpAsString($model->getDescription());
    }

    /** straadaa */
    public function actionDescriptionDetailed()
    {
        $model = new TNdmPvzIn();
        echo VarDumper::dumpAsString($model->getDescriptionDetailed());
    }


    /** straadaa */
    public function actionFindOne(int $id)
    {
        $r = TNdmPvzIn::findOne(['KODS' =>'R']);
        echo VarDumper::dumpAsString($r);
    }


    public function actionTemplatesList(): void
    {
        $model = new TNdmPvzIn();
        echo VarDumper::dumpAsString($model->getTemplatesList());
    }

    /**
     *  ERROR 'Nav ievadīts valūtas  kurss 05.01.1993.!'
     * @param int $id
     * @return void
     */
    public function actionTemplate(int $id): void
    {
        $model = new TNdmPvzIn();
        echo VarDumper::dumpAsString($model->getTemplate($id));
    }

    public function actionWadl(): void
    {
        $model = new TNdmPvzIn();
        echo VarDumper::dumpAsString($model->getWadl());
    }

    public function actionXsd(): void
    {
        $model = new TNdmPvzIn();
        echo VarDumper::dumpAsString($model->getXsd());
    }
}

