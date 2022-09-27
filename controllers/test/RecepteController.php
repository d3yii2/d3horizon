<?php

namespace d3yii2\d3horizon\controllers\test;

use d3system\commands\D3CommandController;
use d3yii2\d3horizon\models\TNdmRecept;
use d3yii2\d3horizon\models\TNdmRecSar;
use d3yii2\d3horizon\Module;
use yii\helpers\Json;
use yii\helpers\VarDumper;


/**
* Class CreditorsController* @property Module $module
*/
class RecepteController extends D3CommandController
{


    /** straadaa */
    public function actionDescription()
    {
        $model = new TNdmRecept();
        echo VarDumper::dumpAsString($model->getDescription());
    }

    /** straadaa */
    public function actionDescriptionDetailed()
    {
        $model = new TNdmRecept();
        echo VarDumper::dumpAsString($model->getDescriptionDetailed());
    }

    /** straadaa */
    public function actionXsd()
    {
        $model = new TNdmRecept();
        echo VarDumper::dumpAsString($model->getXsd());
    }



    /** straadaa */
    public function actionExperiments()
    {
//        $model = new TNdmRecSar();
//        echo VarDumper::dumpAsString(Json::decode($model->getDtata('GET', 'TNdmRecSar/default')));
//        $r = TNdmRecSar::findOne(['KODS' => 'KAV1']);
//        $r = TNdmRecept::findOne(3);
        //$r = TNdmRecept::findOne(['KODS' => 'KAV1']);
        $r = TNdmRecept::findOne(3);
        echo VarDumper::dumpAsString($r->attributes);
        foreach($r->dmNRecRows1 as $k => $recRow1) {
            echo 'recRow1['.$k.']: '.VarDumper::dumpAsString($recRow1->attributes);
        }

    }

    public function actionE2()
    {
        $model = new TNdmRecept();
        $data =  $model->getDtata('
            GET',
            'TNdmRecSar/query?columns=R_COUNTER%2CR_KODS%2CR_NOSAUK%2CR_PK_REC&filter=%28PK_NOM+eq+310%29&limit=1'
        );
        echo VarDumper::dumpAsString($data);
    }

    public function actionE3()
    {
        $model = TNdmRecept::findOneBySarazotasNomenklaturas(311);
        echo VarDumper::dumpAsString($model->attributes);
        foreach($model->dmNRecRows1 as $k => $recRow1) {
            echo 'recRow1['.$k.']: '.VarDumper::dumpAsString($recRow1->attributes);
        }
    }

}

