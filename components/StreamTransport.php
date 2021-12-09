<?php


namespace d3yii2\d3horizon\components;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\TransferStats;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use yii\httpclient\Exception;
use yii\httpclient\Transport;

/**
 * StreamTransport sends HTTP messages using [Streams](http://php.net/manual/en/book.stream.php)
 *
 * For this transport, you may setup request options using [Context Options](http://php.net/manual/en/context.php)
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 2.0
 */
class StreamTransport extends Transport
{
    /**
     * {@inheritdoc}
     */
    public function send($request)
    {
        $request->beforeSend();

        $request->prepare();

        $url = $request->getFullUrl();
        $method = strtoupper($request->getMethod());


        $headers = [];
        foreach ($request->getHeaders() as $name => $values) {
            $name = str_replace(' ', '-', ucwords(str_replace('-', ' ', $name)));
            foreach ($values as $value) {
                $headers[$name] = $value;
            }
        }

        $requestOptions = [
            RequestOptions::HEADERS => $headers,
            RequestOptions::VERIFY => false,
          //  'debug' => true,
            'http_errors' => false,
        ];

        if ($content = $request->getContent()) {
            $requestOptions[RequestOptions::BODY] = $content;
        }
        echo VarDumper::dumpAsString($url);
        echo VarDumper::dumpAsString($requestOptions);
        $token = $request->client->createRequestLogToken($method, $url, $request->composeHeaderLines(), $content);
        Yii::info($token, __METHOD__);
        Yii::beginProfile($token, __METHOD__);
        try {
            $httpClient = new Client();
            /** @var \GuzzleHttp\Psr7\Response $response */
            $response = $httpClient->request(
                $method,
                $url,
                $requestOptions
            );
            usleep(200);
            unset($httpClient);
        } catch (\Exception $e) {
            Yii::endProfile($token, __METHOD__);
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        Yii::endProfile($token, __METHOD__);

        //$response = $request->client->createResponse($responseContent, $responseHeaders);

        $request->afterSend($response);

        return $response;
    }

    /**
     * Composes stream context options from raw request options.
     * @param array $options raw request options.
     * @return array stream context options.
     */
    private function composeContextOptions(array $options)
    {
        $contextOptions = [];
        foreach ($options as $key => $value) {
            $section = 'http';
            if (strpos($key, 'ssl') === 0) {
                $section = 'ssl';
                $key = substr($key, 3);
            }
            $key = Inflector::underscore($key);
            $contextOptions[$section][$key] = $value;
        }
        return $contextOptions;
    }
}
