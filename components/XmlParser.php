<?php

namespace d3yii2\d3horizon\components;

use yii\helpers\Json;
use yii\httpclient\Response;

class XmlParser extends \yii\httpclient\XmlParser
{
    public function parse(Response $response)
    {
        $content = $response->getContent();
        $content = preg_replace('#<entity[^>]+>#','<entity>', $content);
        $xml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
        $json = Json::encode($xml);
        return Json::decode($json);
    }
}
