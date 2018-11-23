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
                $data = Cache::get('BankList');
                return Response::json(compact('data', 200));
            } else {
                $expire = now()->addMinutes(now()->diffInMinutes(now()::tomorrow()));
                $data = $this->sendRequestSOAP("getBankList", ['auth' => $this->auth()], "getBankListResult");
                Cache::add('BankList', $data, $expire);
                return Response::json(compact('data', 200));
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function PSETransactionRequest(Request $request)
    {
        $params = [
            'auth' => $this->auth(),
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

        $response = $this->sendRequestSOAP("createTransaction", $params, "createTransactionResult");

        if (isset($response) && $response["returnCode"] == "SUCCESS") {
            PseTransactionRequest::create($response);
            $expire = now()->addMinutes(30);
            Cache::add('transactionID', $response["transactionID"], $expire);
            return Response::json(compact('response', 200));
        }
        return Response::json(compact('response', 500));
    }

    public function resultTransaction(Request $request)
    {
        if (Cache::has('transactionID')) {
            $response = $this->sendRequestSOAP("getTransactionInformation", [
                'auth' => $this->auth(),
                'transactionID' => Cache::get('transactionID'),
            ], "getTransactionInformationResult");
            return Response::json(compact('response', 200));
        }
    }

    public function sendRequestSOAP($function, $params, $resulData)
    {
        $this->service = InstanceSoapClient::init();
        $response = $this->service->$function($params);
        return $this->loadXmlStringAsArray($response, $resulData);
    }

    public function loadXmlStringAsArray($xmlString, $attr)
    {
        $dat = json_decode(json_encode($xmlString), true);
        return $dat[$attr];
    }

    public function auth()
    {
        $seed = Carbon::now()->format('c');
        return [
            'login' => '6dd490faf9cb87a9862245da41170ff2',
            'tranKey' => sha1($seed . self::$tranKey, false),
            'seed' => $seed,
            'additional' => '',
        ];
    }
}
