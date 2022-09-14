<?php

namespace d3yii2\d3horizon\components;

use simialbi\yii2\rest\Exception as RestException;
use yii\helpers\Json;
use yii\httpclient\Client;
use Yii;
use yii\httpclient\Exception;
use yii\httpclient\Response;
use yii\httpclient\XmlFormatter;

class Connection extends \simialbi\yii2\rest\Connection
{
    public const DATA_FORMAT_JSON = 'json';
    public const DATA_FORMAT_XML = 'xml';
    const HORIZON_POST_XML = 'horizonPostXml';

    public $dataFormat = self::DATA_FORMAT_JSON;

    /** @var string */
    public $horizonApiUsername;

    /** @var string */
    public $horizonApiPassword;
    public function __construct($config = [])
    {
        parent::__construct($config);
        $TH = $this;
        $this->auth = static function () use ($TH) {
            return 'Basic ' . base64_encode($TH->horizonApiUsername . ':' . $TH->horizonApiPassword);
        };
        $this->usePluralisation = false;
    }

    /**
     * Returns the request handler (Guzzle client for the moment).
     * Creates and setups handler if not set.
     * @return Client
     */
    public function getHandler(): Client
    {
        if (static::$_handler === null) {
            $requestConfig = $this->requestConfig;
            $responseConfig = array_merge([
                'class' => Response::class,
                'format' => Client::FORMAT_JSON
            ], $this->responseConfig);
            $clientConfig = array_merge(
                $this->clientConfig,
                [
                    'baseUrl' => $this->baseUrl,
                    'requestConfig' => $requestConfig,
                    'responseConfig' => $responseConfig,
                    'formatters' => [
                        self::HORIZON_POST_XML => [
                            'class' => XmlFormatter::class,
                            'rootTag' => 'resource'
                        ]
                    ]
                ]
            );
            static::$_handler = new Client($clientConfig);
            static::$_handler->setTransport(StreamTransport::class);
        }

        return static::$_handler;
    }

    protected function request(string $method, $url, array $data = [])
    {
        if (is_array($url)) {
            $path = array_shift($url);
            $query = http_build_query($url);
            
            array_unshift($url, $path);
            if ($query) {
                $path .= '?' . $query;
            }
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
            $headers['Content-type'] = 'application/json; charset=UTF-8';
            $headers['User-Agent'] = 'Apache-HttpClient/4.5.13 (Java/11.0.13)';
            $headers['Accept-Encoding'] =  'gzip,deflate';
            $headers['Connection'] = 'Keep-Alive';
            $this->requestConfig['format'] = Client::FORMAT_JSON;
            $this->responseConfig['format'] = Client::FORMAT_JSON;
        }
        $request->format = self::DATA_FORMAT_JSON;

        // Original parent request does not include base auth header, so hacked here
        $request->setHeaders($headers);
        $request->addOptions(['protocol_version' => '1.1']);

        try {
            /** @var \GuzzleHttp\Psr7\Response $response */
            $response = $this->isTestMode ? [] : $request->send();
            $responseContentData = [];
            $responseContent = '';
            $stream = $response->getBody();
            if (!$this->isTestMode && $responseContent =  $stream->getContents()) {
                $responseContentData = Json::decode($responseContent);
            }
            $stream->tell();
            $stream->close();
        } catch (Exception $e) {
            throw new RestException('Request failed', [], 1, $e);
        }
        Yii::endProfile($profile, __METHOD__);
        $statusCode = $response->getStatusCode();
        if (!$this->isTestMode) {
            if ((string)$statusCode === '404') {
                return false;
            }
            if (strncmp('20', $response->getStatusCode(), 2) !== 0) {
                if ($this->enableExceptions) {
                    throw new RestException($responseContent, $response->getHeaders());
                }
                return false;
            }
        }

        return $responseContentData;
    }

    /**
     * @throws \yii\httpclient\Exception
     */
    public static function responseGetIsOk($response): bool
    {
        return strncmp('20', $response->getStatusCode(), 2) === 0;
    }
}
