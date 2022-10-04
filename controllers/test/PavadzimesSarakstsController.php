<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\TNdmNom;
use d3yii2\d3horizon\models\TNdmPvzRaz;
use d3yii2\d3horizon\models\TNdmPvzSar;
use d3yii2\d3horizon\models\TNdmRecSar;
use d3yii2\d3horizon\Module;
use yii\helpers\Json;
use yii\helpers\VarDumper;


/**
* Class CreditorsController* @property Module $module
*/
class PavadzimesSarakstsController extends D3CommandController
{


    /** straadaa */
    public function actionDescription()
    {
        $model = new TNdmPvzSar();
        echo VarDumper::dumpAsString($model->getDescription());
    }

    /** straadaa */
    public function actionDescriptionDetailed()
    {
        $model = new TNdmPvzSar();
        echo VarDumper::dumpAsString($model->getDescriptionDetailed());
    }

    /** straadaa */
    public function actionIndexDefault()
    {
        $model = new TNdmPvzSar();
//        echo VarDumper::dumpAsString(Json::decode($model->getDefault()));
        echo $model->getDefault();

    }

    /** straadaa */
    public function actionFindOne(int $id = 3)
    {
        $r = TNdmPvzSar::findOne($id);
        echo VarDumper::dumpAsString($r->attributes);
    }

    public function actionFindAllByDokNumber(string $number)
    {
        $r = TNdmPvzSar::find()
            ->select([
                'DOK_NR',
                'DAT_DOK',
                'KOP_SUMMA_IZIEP'
            ])
            ->where(['DOK_NR' => $number])
            ->all()
        ;
        foreach ($r as $rn) {
            echo VarDumper::dumpAsString($rn->attributes);
        }
    }


    public function actionNom()
    {
//        $r = TNdmNom::findOne(7926);
//        echo VarDumper::dumpAsString($r->attributes);
        $model = new TNdmNom();
        echo $model->getXsd();


    }

    /** nestraadaa */
    public function actionDefault(): void
    {
        $model = new TNdmPvzSar();
        //echo VarDumper::dumpAsString(Json::decode($model->getDtata('GET', 'TNdmRecSar/default')));
        echo $model->getDefault();
    }

    public function actionFindByNumber(string $number)
    {
        foreach (TNdmPvzSar::findAll(['DOK_NR' => $number]) as $p) {
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
        $model = new TNdmPvzSar();
        $template = $model->getTemplate($id);
        echo VarDumper::dumpAsString($template->attributes);
    }

    public function actionTemplatesList(): void
    {
        $model = new TNdmPvzSar();
        echo VarDumper::dumpAsString(Json::decode($model->getTemplatesList()));
    }

    public function actionWadl(): void
    {
        $model = new TNdmPvzSar();
        echo VarDumper::dumpAsString($model->getWadl());
    }

    public function actionXsd(): void
    {
        $model = new TNdmPvzSar();
        echo VarDumper::dumpAsString($model->getXsd());
    }
}

