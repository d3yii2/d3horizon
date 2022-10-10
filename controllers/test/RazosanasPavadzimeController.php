<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\TNdmPvzRaz;
use d3yii2\d3horizon\Module;
use yii\helpers\Json;
use yii\helpers\VarDumper;


/**
* Class CreditorsController* @property Module $module
*/
class RazosanasPavadzimeController extends D3CommandController
{


    /** straadaa */
    public function actionDescription()
    {
        $model = new TNdmPvzRaz();
        echo VarDumper::dumpAsString($model->getDescription());
    }

    /** straadaa */
    public function actionDescriptionDetailed()
    {
        $model = new TNdmPvzRaz();
        echo VarDumper::dumpAsString($model->getDescriptionDetailed());
    }

    /** straadaa */
    public function actionIndexDefault()
    {
        $model = new TNdmPvzRaz();
//        echo VarDumper::dumpAsString(Json::decode($model->getDefault()));
        echo $model->getDefault();

    }

    /** straadaa */
    public function actionFindOne(int $id)
    {

        /** @var TNdmPvzRaz $r */
        $r = TNdmPvzRaz::findOne($id);


        echo VarDumper::dumpAsString($r->attributes) . PHP_EOL;
        echo 'tblRindas' . PHP_EOL;
        foreach ($r->tblRindas as $rr) {
            echo VarDumper::dumpAsString($rr->attributes) . PHP_EOL;
        }
        echo 'tblRindasR' . PHP_EOL;
        foreach ($r->tblRindasR as $rr) {
            echo VarDumper::dumpAsString($rr->attributes) . PHP_EOL;
        }
        echo 'qrySubRindas' . PHP_EOL;
        foreach ($r->qrySubRindas as $rr) {
            echo VarDumper::dumpAsString($rr->attributes) . PHP_EOL;
        }
    }

    /** nestraadaa */
    public function actionDefault(): void
    {
        $model = new TNdmPvzRaz();
        //echo VarDumper::dumpAsString(Json::decode($model->getDtata('GET', 'TNdmRecSar/default')));
        echo VarDumper::dumpAsString($model->getDefault());
    }

    public function actionFindAll()
    {
        foreach (TNdmPvzRaz::findAll([]) as $p) {
            $this->out(VarDumper::dumpAsString($p->attributes));
        }
    }

    /**
     *  ERROR 'Nav ievadīts valūtas  kurss 05.01.1993.!'
     * @param int $id
     * @return void
     */
    public function actionTemplate(int $id = 37): void
    {
        $model = new TNdmPvzRaz();
        $template = $model->getTemplate($id);
        echo VarDumper::dumpAsString($template->attributes);
    }

    public function actionTemplatesList(): void
    {
        $model = new TNdmPvzRaz();
        echo VarDumper::dumpAsString(Json::decode($model->getTemplatesList()));
    }

    public function actionWadl(): void
    {
        $model = new TNdmPvzRaz();
        echo VarDumper::dumpAsString($model->getWadl());
    }

    public function actionXsd(): void
    {
        $model = new TNdmPvzRaz();
        echo VarDumper::dumpAsString($model->getXsd());
    }

}

