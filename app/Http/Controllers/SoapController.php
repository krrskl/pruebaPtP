<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Response;
use \Cache as Cache;

class SoapController extends BaseSoapController
{
    private $service;
    protected static $tranKey = '024h1IlD';
    public function getBankList()
    {
        try {

            if (Cache::has('BankList')) {
                $data = $this->loadXmlStringAsArray(Cache::get('BankList'));
                return Response::json(compact('data', 200));
            } else {
                echo "El elemento no está en caché <br>";

                $this->service = InstanceSoapClient::init();

                $seed = $this->getDateISO8601();
                $params = [
                    'auth' => [
                        'login' => '6dd490faf9cb87a9862245da41170ff2',
                        'tranKey' => $this->getHash($seed, self::$tranKey),
                        'seed' => $seed,
                        'additional' => '',
                    ],
                ];

                $response = $this->service->getBankList($params);
                $expire = now()->addMinutes(now()->diffInMinutes(now()::tomorrow()));
                Cache::add('BankList', $response, $expire);

                $data = $this->loadXmlStringAsArray(Cache::get('BankList'));
                return Response::json(compact('data', 200));
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getDateISO8601()
    {
        return Carbon::now()->format('c');
    }

    public function getHash($seed, $tranKey)
    {
        return sha1($seed . $tranKey, false);
    }

    public function loadXmlStringAsArray($xmlString)
    {
        $dat = json_decode(json_encode($xmlString), true);
        return $dat["getBankListResult"];
    }
}
