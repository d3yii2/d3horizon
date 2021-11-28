<?php

namespace d3yii2\d3horizon\components;

use simialbi\yii2\rest\Exception as RestException;
use yii\httpclient\Client;
use Yii;

class Connection extends \simialbi\yii2\rest\Connection
{
    public const DATA_FORMAT_JSON = 'json';
    public const DATA_FORMAT_XML = 'xml';
    
    public $dataFormat = self::DATA_FORMAT_JSON;
    
    protected function request(string $method, $url, array $data = [])
    {
        if (is_array($url)) {
            $path = array_shift($url);
            $query = http_build_query($url);
            
            array_unshift($url, $path);
            
            $path .= '?' . $query;
        } else {
            $path = $url;
        }
        
        $headers = [];
        $method = strtoupper($method);
        $profile = $method . ' ' . $this->handler->baseUrl . '/' . $path . '#' . (is_array($data) ? http_build_query($data) : $data);
        
        if ($auth = $this->getAuth()) {
            $headers['Authorization'] = $auth;
        }
        if ($method === 'head') {
            $data = $headers;
            $headers = [];
        }
        
        Yii::beginProfile($profile, __METHOD__);
        /* @var $request \yii\httpclient\Request */
        
        Yii::debug($method, __METHOD__ . '-method');
        Yii::debug($this->handler->baseUrl . '/' . $path, __METHOD__ . '-url');
        Yii::debug($data, __METHOD__ . '-data');
        Yii::debug($headers, __METHOD__ . '-headers');
        
        // By unknown  reason base auth header is still missing after this.
        $request = call_user_func([$this->handler, $method], $url, $data, $headers);
        
        // Optimized for JSON default
        if (self::DATA_FORMAT_JSON === $this->dataFormat) {
            $headers['Accept'] = 'application/json';
            $this->requestConfig['format'] = Client::FORMAT_JSON;
            $this->responseConfig['format'] = Client::FORMAT_JSON;
        }
        
        // Original parent request does not include base auth header, so hacked here
        $request->setHeaders($headers);

        try {
            $this->_response = $this->isTestMode ? [] : $request->send();
        } catch (\yii\httpclient\Exception $e) {
            throw new RestException('Request failed', [], 1, $e);
        }
        Yii::endProfile($profile, __METHOD__);
        
        if (!$this->isTestMode && !$this->_response->isOk) {
            if ($this->enableExceptions) {
                throw new RestException($this->_response->content, $this->_response->headers->toArray());
            }
            return false;
        }
        
        return $this->isTestMode ? [] : $this->_response->data;
    }
}
