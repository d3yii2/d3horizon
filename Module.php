<?php

namespace d3yii2\d3horizon;

use Yii;
use d3system\yii2\base\D3Module;

class Module extends D3Module
{
    public $controllerNamespace = 'd3yii2\d3horizon\controllers';

    public $leftMenu = 'd3yii2\d3horizon\LeftMenu';

    public function getLabel(): string
    {
        return Yii::t('d3horizon','Horizon API module');
    }
}
