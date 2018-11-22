<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use \Cache as Cache;

class SoapController extends BaseSoapController
{
    private $service;
    protected static $tranKey = '024h1IlD';
    public function getBankList()
    {
        try {

            if (Cache::has('BankList')) {
                echo "Cacheado <br>";

                dd(Cache::get('BankList'));
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

                $data = $this->service->getBankList($params);
                $expire = now()->addMinutes(1);
                Cache::add('BankList', $data, $expire);

                dd($data);
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
}
