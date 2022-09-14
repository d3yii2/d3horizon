<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\TNdmNom;
use d3yii2\d3horizon\Module;
use d3yii2\d3horizon\models\Creditor;
use yii\helpers\VarDumper;
use d3yii2\d3horizon\models\TDdmCustomerKred;
use d3yii2\d3horizon\models\TDdmCustomerDeb;
use d3yii2\d3horizon\models\TNdmPvzIn;

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

    /** straada */
    public function actionIndex()
    {

        //NCLT112A

//        $models = TNdmNom::findOne(['KODS' => 'NCLT112A']);
//        foreach ($models as $model) {
//            $this->out(VarDumper::dumpAsString($model->attributes));
//        }

//        $models = TNdmNom::findAll(['KODS' => 'NCLT112A']);
//        foreach ($models as $model) {
//            $this->out(VarDumper::dumpAsString($model->attributes));
//        }
//        $models = TNdmNom::find()->where(['KODS' => 'NCLT112A'])->all();
//        foreach ($models as $model) {
//            $this->out(VarDumper::dumpAsString($model->attributes));
//        }

        $model = new TNdmNom();

        $model->KODS = 'NCLT115';
        $model->NOSAUK = 'CLT69 C 3(23-23-23)V/V/1051/1051';
        $model->PK_NOMGR = 2;
        $model->PK_VIEN = 13; //gabali
        $model->STATUSS = 0;
        if (!$model->save()) {
            $this->out(VarDumper::dumpAsString($model->errors));
        }
        $this->out('PK_NOM: ' . $model->PK_NOM);

        $model->KODS .= 'A';
        $model->save();


        if ($model2=TNdmNom::findOne($model->PK_NOM)) {
            $this->out(VarDumper::dumpAsString($model2->attributes));
        }
        $this->out('delete');
        $count = $model2->delete();
        $this->out('Count: ' . $count);

    }

    /** nestrada */
    public function actionIndex1()
    {
        //$res = Creditor::find()->one();
        //$res = Creditor::findOne(8);
        $res = Creditor::findAll();
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

    /**
     * strada
     * @return void
     */
    public function actionCustomerList()
    {

        $customer = new TDdmCustomerKred();
        $customer->TIPS = 3;
        $customer->NOSAUK = 'TEST-INSERT';
        $customer->REG_NR = '40000000000';
        $customer->ADRESE = 'Garā iela 5, Alūksne LV5511';
        $customer->PVN_REGNR = 'LV40000000000';
        $customer->STATUSS = 1;

        $customer->save();
    }

    /** straadaa */
    public function actionDescription()
    {

        $customer = new TDdmCustomerKred();
        echo VarDumper::dumpAsString($customer->getDescription());
    }

    /** straadaa */
    public function actionPavadzimeList()
    {

        $model = TNdmPvzIn::findOne(['PAMV_ID' => '2710']);

    }
}

