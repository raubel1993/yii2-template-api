<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class BaseCurl extends Component
{
    public $urlBase;

    public $headers = [
        "accept" => "application/json",
        "content-type" => "application/json",
    ];

    public $timeout = 60;
    public $connectTimeout = 60;
    public $verifyHost = false;
    public $verifyPeer = false;
    public $followLocation = true;

    public function __construct($config = [])
    {
        if (!isset($config['urlBase'])) {
            throw new InvalidConfigException('urlBase debe ser configurado');
        }
        parent::__construct($config);
    }
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }
    public function deleteHeader($key)
    {
        unset($this->headers[$key]);
    }

    protected function connect($url, $verb = "GET", $body = [])
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->urlBase . $url,
            CURLOPT_CUSTOMREQUEST => $verb,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_SSL_VERIFYHOST => $this->verifyHost,
            CURLOPT_SSL_VERIFYPEER => $this->verifyPeer,
            CURLOPT_FOLLOWLOCATION => $this->followLocation,
        ]);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getBuildHeaders());

        if ($body) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        }
        $response = json_decode(curl_exec($curl), true);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        //Yii::error($response, 'response');
        //Yii::error($httpCode, 'httpCode');
        //Yii::error($err, 'err');
        curl_close($curl);
        if ($httpCode >= 200 && $httpCode < 300) {
            return $response;
        }
        throw new \yii\web\HttpException(503, print_r($err ?? $response, true));
    }
    private function getBuildHeaders()
    {
        $headers = [];
        foreach ($this->headers as $key => $value) {
            $headers[] = "$key: $value";
        }
        return $headers;
    }
}
