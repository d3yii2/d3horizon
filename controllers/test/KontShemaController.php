<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\TdmBLKontShema;
use Exception;
use yii\helpers\VarDumper;



class KontShemaController extends D3CommandController
{


    /** straadaa */
    public function actionDescription()
    {
        $model = new TdmBLKontShema();
        echo VarDumper::dumpAsString($model->getDescription());
    }

    /** straadaa */
    public function actionDescriptionDetailed()
    {
        $model = new TdmBLKontShema();
        echo VarDumper::dumpAsString($model->getDescriptionDetailed());
    }


    /** straadaa */
    public function actionFindOne(int $id)
    {
        $r = TdmBLKontShema::findOne($id);
        echo VarDumper::dumpAsString($r->attributes);
    }

    /** straadaa */
    public function actionFindAll(int $idFrom = 1, int $idTo = 1000)
    {
        for ($i = $idFrom; $i < $idTo; $i++) {
            try {
                /** @var TdmBLKontShema $r */
                $r = TdmBLKontShema::findOneByPk($i,60*60);
                if ($r->KODS === '1' && $r->isDocRazosanasPavadzime()) {
                    echo VarDumper::dumpAsString($r->attributes);
                }
            } catch (Exception $e) {
                if ($e->getMessage() === 'ERestException: Kontējumu shēma: Ieraksts netika atrasts!') {
                    $this->out($i . ': -');
                } else {
                    throw $e;
                }
            }
        }
    }

    public function actionTemplatesList(): void
    {
        $model = new TdmBLKontShema();
        echo VarDumper::dumpAsString($model->getTemplatesList());
    }

    /**
     *  ERROR 'Nav ievadīts valūtas  kurss 05.01.1993.!'
     * @param int $id
     * @return void
     */
    public function actionTemplate(int $id): void
    {
        $model = new TdmBLKontShema();
        echo VarDumper::dumpAsString($model->getTemplate($id));
    }

    public function actionWadl(): void
    {
        $model = new TdmBLKontShema();
        echo VarDumper::dumpAsString($model->getWadl());
    }

    public function actionXsd(): void
    {
        $model = new TdmBLKontShema();
        echo VarDumper::dumpAsString($model->getXsd());
    }
}

