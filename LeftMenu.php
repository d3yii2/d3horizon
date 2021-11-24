<?php
namespace d3yii2\d3horizon;

use Yii;

class LeftMenu {

    public function list()
    {
        $user = Yii::$app->user;
        return [
            [
                'label' => Yii::t('d3horizon', '????'),
                'type' => 'submenu',
                //'icon' => 'truck',
                'url' => ['/Yii2 Horizon API/????/index'],
            ],
        ];
    }
}
