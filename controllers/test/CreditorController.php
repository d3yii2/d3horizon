<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\TNdmNom;
use d3yii2\d3horizon\Module;
use yii\console\ExitCode;
use d3yii2\d3horizon\models\Creditor;
use yii\helpers\VarDumper;

/**
* Class CreditorsController* @property Module $module
*/
class CreditorController extends D3CommandController
{
    /**
     * default action
     * @return int
     */
    public function actionIndexA()
    {
        //$res = Creditor::find()->one();
        //$res = Creditor::findAll([]);
        //print_r($res);


        $creditor = new Creditor();
        //$creditor->KODS
        $creditor->PK_DOKT =2;
        $creditor->TIPS =Creditor::TIPS_COMPANY;
        $creditor->NOSAUK = 'NCLT2';
        $creditor->REG_NR = '40003281915';
        $creditor->PVN_REGNR = 'LV40003281915';
        //$creditor->PK_VALSTS = 1;
        $creditor->ADRESE = 'Garā iela 6, Alūksne LV5511';
        if (!$creditor->save()) {
            $this->out(VarDumper::dumpAsString($creditor->errors));
        }
    }

    public function actionIndex()
    {
        /*
        $model = new TNdmNom();

        $model->KODS = 'NCLT013';
        $model->NOSAUK = 'CLT69 C 3(23-23-23)V/V/1300/1300';
        $model->PK_NOMGR = 2;
        $model->PK_VIEN = 13; //gabali
        //$model->PK_LIKME = 1;
        $model->STATUSS = 0;
        //$model->PK_DNORGRP = 1;
        if (!$model->save()) {
            $this->out(VarDumper::dumpAsString($model->errors));
        }
        $this->out('id: ' . $model->id);

        if ($model2=TNdmNom::findOne($model->id)) {
            $this->out(VarDumper::dumpAsString($model2->attributes));
        } else {
            $this->out('neatrada: '. $model->id);
        }
        */
        $list = TNdmNom::find()->where(['KODS' =>'NCLT013'])->all();
        VarDumper::dumpAsString($list);
    }

    public function actionIndex1()
    {
        //$res = Creditor::find()->one();
        $res = Creditor::findOne(8);
        //$res = Creditor::findAll([]);
        print_r($res->attributes);
    }

    public function actionCreate()
    {
        $creditor = new Creditor();
        //$creditor->KODS
        $creditor->TIPS = 3;
        $creditor->NOSAUK = 'NCLT';
        $creditor->REG_NR = '40003081915';
        $creditor->PVN_REGNR = 'LV40003081915';
        $creditor->PK_VALSTS = 1;
        $creditor->ADRESE = 'Garā iela 5, Alūksne LV5511';
        $creditor->save();
    }
}

