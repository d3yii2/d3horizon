<?php

namespace d3yii2\d3horizon\components;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use yii\base\Component;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\httpclient\Exception;

class RestConnection extends Component
{


    /** @var string */
    public $baseUrl;

    /** @var string */
    public $horizonApiUsername;

    /** @var string */
    public $horizonApiPassword;

    /** @var array  */
    public $headers = [];

    /** @var bool  */
    public $enableExceptions =  false;

    /** @var \GuzzleHttp\Psr7\Response */
    public $response;
    /**
     * @var array|null
     */
    private $_responseContent;
    /**
     * @var string
     */
    private $_rawResponse;

    private function getHeaders(): array
    {
        if (!$this->headers) {
            $this->headers['Authorization'] = 'Basic ' . base64_encode($this->horizonApiUsername . ':' . $this->horizonApiPassword);
            $this->headers['Accept'] = 'application/json';
            $this->headers['Content-type'] = 'application/json; charset=UTF-8';
            $this->headers['User-Agent'] = 'Apache-HttpClient/4.5.13 (Java/11.0.13)';
            $this->headers['Accept-Encoding'] =  'gzip,deflate';
            $this->headers['Connection'] = 'Keep-Alive';
        }
        return $this->headers;
    }


    /**
     * @throws \yii\httpclient\Exception
     * @throws \simialbi\yii2\rest\Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $method, $path, array $data = [], array $get = [])
    {
        $this->_responseContent = null;
        $this->response = null;
        $url = $this->baseUrl . '/' . $path;
        if (is_array($get)) {
            $query = http_build_query($get);
            if ($query) {
                $url .= '?' . $query;
            }
        }
        $requestOptions = [
            RequestOptions::HEADERS => $this->getHeaders(),
            RequestOptions::VERIFY => false,
            //  'debug' => true,
            'http_errors' => false,
        ];

        if ($data) {
            $requestOptions[RequestOptions::BODY] = Json::encode($data);
        }

        echo VarDumper::dumpAsString($requestOptions);
        echo VarDumper::dumpAsString($url);
        try {
            $httpClient = new Client();
            /** @var \GuzzleHttp\Psr7\Response $response */
            $this->response = $httpClient->request(
                $method,
                $url,
                $requestOptions
            );
            unset($httpClient);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }


        $statusCode = $this->response->getStatusCode();

        if ((string)$statusCode === '404') {
            return false;
        }
        if (strncmp('20', $statusCode, 2) !== 0) {
            if ($this->enableExceptions) {
                $stream = $this->response->getBody();
                $responseContent =  $stream->getContents();
                throw new RestException($responseContent, $this->response->getHeaders());
            }
            return false;
        }

        return $this->response;
    }

    /**
     * @throws \yii\httpclient\Exception
     */
    public static function responseGetIsOk($response): bool
    {
        return strncmp('20', $response->getStatusCode(), 2) === 0;
    }

    public function getResponseContent(): ?string
    {
        if ($this->_responseContent) {
            return $this->_rawResponse;
        }
        $stream = $this->response->getBody();
        if ($this->_rawResponse =  $stream->getContents()) {
            $this->_responseContent = Json::decode($this->_rawResponse);
        }
        return $this->_rawResponse;
    }
    public function getResponseData()
    {
        if ($this->_responseContent) {
            return $this->_responseContent;
        }
        if (!$this->response) {
            return [];
        }
        return $this->_responseContent =  Json::decode($this->getResponseContent());
    }
}
