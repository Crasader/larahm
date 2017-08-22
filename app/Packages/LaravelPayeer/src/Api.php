<?php

namespace entimm\LaravelPayeer;

use GuzzleHttp\Client;

/**
 * Class Api
 */
class Api {

    private $url = 'https://payeer.com/ajax/api/api.php';

    private $auth = [];

    private $output;
    private $errors;
    private $language = 'en';

    public function __construct($account, $apiId, $apiPass)
    {
        $this->client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; rv:12.0) Gecko/20100101 Firefox/12.0',
            ],
            'timeout'  => config('payeer.timeout'),
            'verify' => false,
        ]);

        $arr = [
            'account' => $account,
            'apiId' => $apiId,
            'apiPass' => $apiPass,
        ];

        $response = $this->getResponse($arr);

        if ($response['auth_error'] == '0') {
            $this->auth = $arr;
        }
    }

    public function isAuth()
    {
        if (!empty($this->auth)) {
            return true;
        }
        return false;
    }

    private function getResponse($data)
    {
        if ($this->isAuth()) {
            $data = array_merge($data, $this->auth);
        }
        $data['language'] = $this->language;

        $content = $this->client->request('POST', $this->url, [
            'form_params' => $data,
        ])->getBody()->getContents();

        $content = json_decode($content, true);

        if (isset($content['errors']) && !empty($content['errors'])) {
            $this->errors = $content['errors'];
        }

        return $content;
    }

    public function getPaySystems()
    {
        $arPost = array(
            'action' => 'getPaySystems',
        );

        $response = $this->getResponse($arPost);

        return $response;
    }

    public function initOutput($arr)
    {
        $arPost = $arr;
        $arPost['action'] = 'initOutput';

        $response = $this->getResponse($arPost);

        if (empty($response['errors'])) {
            $this->output = $arr;
            return true;
        }

        return false;
    }

    public function output()
    {
        $arPost = $this->output;
        $arPost['action'] = 'output';

        $response = $this->getResponse($arPost);

        if (empty($response['errors'])) {
            return $response['historyId'];
        }

        return false;
    }

    public function getHistoryInfo($historyId)
    {
        $arPost = [
            'action' => 'historyInfo',
            'historyId' => $historyId
        ];

        $response = $this->getResponse($arPost);

        return $response;
    }

    public function getBalance()
    {
        $arPost = [
            'action' => 'balance',
        ];

        $response = $this->getResponse($arPost);

        return $response;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function transfer($arPost)
    {
        $arPost['action'] = 'transfer';

        $response = $this->getResponse($arPost);

        return $response;
    }

    public function SetLang($language)
    {
        $this->language = $language;
        return $this;
    }

    public function getShopOrderInfo($arPost)
    {
        $arPost['action'] = 'shopOrderInfo';

        $response = $this->getResponse($arPost);

        return $response;
    }

    public function checkUser($arPost)
    {
        $arPost['action'] = 'checkUser';

        $response = $this->getResponse($arPost);

        if (empty($response['errors'])) {
            return true;
        }

        return false;
    }

    public function getExchangeRate($arPost)
    {
        $arPost['action'] = 'getExchangeRate';

        $response = $this->getResponse($arPost);

        return $response;
    }

    public function merchant($arPost)
    {
        $arPost['action'] = 'merchant';

        $arPost['shop'] = json_encode($arPost['shop']);
        $arPost['form'] = json_encode($arPost['form']);
        $arPost['ps'] = json_encode($arPost['ps']);

        if (empty($arPost['ip'])) {
            $arPost['ip'] = env('REMOTE_ADDR');
        }

        $response = $this->getResponse($arPost);

        if (empty($response['errors'])) {
            return $response;
        }

        return false;
    }
}