<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\TdmNumerator;
use d3yii2\d3horizon\models\TNdmNolPartSarDlg;
use d3yii2\d3horizon\models\TNdmNolSar;
use d3yii2\d3horizon\models\TNdmPvzRaz;
use d3yii2\d3horizon\models\TNdmRecSar;
use d3yii2\d3horizon\Module;
use yii\helpers\Json;
use yii\helpers\VarDumper;



class PartijasController extends D3CommandController
{


    /** straadaa */
    public function actionDescription()
    {
        $model = new TNdmNolPartSarDlg();
        echo VarDumper::dumpAsString($model->getDescription());
    }

    /** straadaa */
    public function actionDescriptionDetailed()
    {
        $model = new TNdmNolPartSarDlg();
        echo VarDumper::dumpAsString($model->getDescriptionDetailed());
    }


    /** straadaa */
    public function actionFindOne(int $id)
    {
        $r = TNdmNolPartSarDlg::findOne(['PK_NOMPART' =>377144]);
        echo VarDumper::dumpAsString($r->attributes);
    }

    public function actionNomenk(int $id)
    {
        $r = TNdmNolPartSarDlg::find()
            ->where([
                'N_PK_NOM' => $id,
                'ATL_DAUDZ gt 0'
            ])
            ->orderby(['DAT_PART' => SORT_ASC])
            ->all();
        foreach ($r as $rr) {
            echo VarDumper::dumpAsString($rr->attributes) . PHP_EOL;
        }
    }


    public function actionTemplatesList(): void
    {
        $model = new TNdmNolPartSarDlg();
        echo VarDumper::dumpAsString($model->getTemplatesList());
    }

    /**
     *  ERROR 'Nav ievadīts valūtas  kurss 05.01.1993.!'
     * @param int $id
     * @return void
     */
    public function actionTemplate(int $id): void
    {
        $model = new TNdmNolPartSarDlg();
        echo VarDumper::dumpAsString($model->getTemplate($id));
    }

    public function actionWadl(): void
    {
        $model = new TNdmNolPartSarDlg();
        echo VarDumper::dumpAsString($model->getWadl());
    }

    public function actionXsd(): void
    {
        $model = new TNdmNolPartSarDlg();
        echo VarDumper::dumpAsString($model->getXsd());
    }
}

