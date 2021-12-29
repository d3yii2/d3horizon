<?php

namespace d3yii2\d3horizon\models;

class TDdmCustomerDeb extends TDdmCustomerKred
{

    public static function apiRequestQuery(): string
    {
        return 'TDdmKDebSar/query';
    }

}