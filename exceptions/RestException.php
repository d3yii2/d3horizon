<?php

namespace d3yii2\d3horizon\exceptions;

use yii\base\Exception;
use yii\helpers\Json;

class RestException extends Exception
{
    public function __construct(string $responseContent)
    {
        try {
            $response = Json::decode($responseContent);
            parent::__construct($response['class'] . ': ' . $response['message']);
        } catch (\Exception $exception) {
            parent::__construct($responseContent);
        }
    }
}