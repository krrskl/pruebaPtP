<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

class SoapController extends BaseSoapController
{
    private $service;
    protected static $tranKey = '024h1IlD';
    public function getBankList()
    {
        try {
            $this->service = InstanceSoapClient::init();

            $seed = Carbon::now()->format('c');
            $params = [
                'auth' => [
                    'login' => '6dd490faf9cb87a9862245da41170ff2',
                    'tranKey' => $this->getHash($seed, self::$tranKey),
                    'seed' => $seed,
                    'additional' => ''
                ],
            ];
            dd($this->service->getBankList($params));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getDateISO8601()
    {
        return date('c');
    }

    public function getHash($seed, $tranKey)
    {
        return sha1($seed . $tranKey, false);
    }
}
