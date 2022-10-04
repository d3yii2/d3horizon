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


    public function actionIndexDefault()
    {
        $model = new TNdmRecept();
        echo VarDumper::dumpAsString($model->getDefault());
    }

    /**
     * @throws \simialbi\yii2\rest\Exception
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function actionFindOne(int $id)
    {
        /** @var TNdmRecept $model */
        $model =  TNdmRecept::findOne($id);

        echo VarDumper::dumpAsString($model->attributes) . PHP_EOL;
        echo 'ROWS ' . PHP_EOL;
        foreach ($model->dmNRecRows as $r) {
            echo VarDumper::dumpAsString($r->attributes) . PHP_EOL;
        }
        echo 'ROWS1 ' . PHP_EOL;
        foreach ($model->dmNRecRows1 as $r) {
            echo VarDumper::dumpAsString($r->attributes) . PHP_EOL;
        }
    }

    public function actionFindAll()
    {
        foreach (TNdmRecept::findAll([]) as $recept) {
            $this->out(VarDumper::dumpAsString($recept->attributes));
        }
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
        $rcepte = TNdmRecept::findOne(['KODS' => 10113]);
        echo VarDumper::dumpAsString($rcepte->attributes) . PHP_EOL;
        echo 'ROWS ' . PHP_EOL;
        foreach ($rcepte->dmNRecRows as $r) {
            echo VarDumper::dumpAsString($r->attributes) . PHP_EOL;
        }
        echo 'ROWS1 ' . PHP_EOL;
        foreach ($rcepte->dmNRecRows1 as $r) {
            echo VarDumper::dumpAsString($r->attributes) . PHP_EOL;
        }
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

