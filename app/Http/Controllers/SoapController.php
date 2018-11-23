<?php
namespace App\Http\Controllers;

use App\Person;
use App\PSETransactionRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
                $data = $this->loadXmlStringAsArray(Cache::get('BankList'), "getBankListResult");
                return Response::json(compact('data', 200));
            } else {
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

                $data = $this->loadXmlStringAsArray(Cache::get('BankList'), "getBankListResult");
                return Response::json(compact('data', 200));
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function PSETransactionRequest(Request $request)
    {
        $seed = $this->getDateISO8601();
        $params = [
            'auth' => [
                'login' => '6dd490faf9cb87a9862245da41170ff2',
                'tranKey' => $this->getHash($seed, self::$tranKey),
                'seed' => $seed,
                'additional' => '',
            ],
            'transaction' => [
                "bankCode" => $request->input('bankCode'),
                "bankInterface" => $request->input('bankInterface'),
                "returnURL" => "http://localhost:8000/ptp/statusTransaction",
                "reference" => $request->input('reference'),
                "description" => $request->input('description'),
                "language" => $request->input('language'),
                "currency" => $request->input('currency'),
                "totalAmount" => $request->input('totalAmount'),
                "taxAmount" => $request->input('taxAmount'),
                "devolutionBase" => $request->input('devolutionBase'),
                "tipAmount" => $request->input('tipAmount'),
                "payer" => Person::find($request->only('payer'))[0],
                "buyer" => Person::find($request->only('buyer'))[0],
                "shipping" => Person::find($request->only('shipping'))[0],
                "ipAddress" => $request->ip(),
                "userAgent" => $request->server('HTTP_USER_AGENT'),
            ],
        ];

        $this->service = InstanceSoapClient::init();
        $response = $this->service->createTransaction($params);

        if (isset($response)) {
            $response = $this->loadXmlStringAsArray($response, "createTransactionResult");
            if ($response["returnCode"] == "SUCCESS") {
                PseTransactionRequest::create($response);
                $expire = now()->addMinutes(30);
                Cache::add('transactionID', $response["transactionID"], $expire);
                return Response::json(compact('response', 200));
            }
        }
        return Response::json(compact('response', 500));
    }

    public function resultTransaction(Request $request)
    {
        if (Cache::has('transactionID')) {
            $seed = $this->getDateISO8601();
            $params = [
                'auth' => [
                    'login' => '6dd490faf9cb87a9862245da41170ff2',
                    'tranKey' => $this->getHash($seed, self::$tranKey),
                    'seed' => $seed,
                    'additional' => '',
                ],
                'transactionID' => Cache::get('transactionID'),
            ];
            $this->service = InstanceSoapClient::init();
            $response = $this->service->getTransactionInformation($params);
            $response = $this->loadXmlStringAsArray($response, "getTransactionInformationResult");
            return Response::json(compact('response', 200));
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

    public function loadXmlStringAsArray($xmlString, $attr)
    {
        $dat = json_decode(json_encode($xmlString), true);
        return $dat[$attr];
    }
}
