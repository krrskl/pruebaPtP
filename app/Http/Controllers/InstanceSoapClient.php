<?php
namespace App\Http\Controllers;

use SoapClient;

class InstanceSoapClient extends BaseSoapController
{
    public static function init()
    {
        $urlWsdl = 'https://test.placetopay.com/soap/pse/?wsdl';
        $soapClientOptions = array(
            'stream_context' => self::generateContext(),
            'cache_wsdl' => WSDL_CACHE_NONE,
        );
        return new SoapClient($urlWsdl, $soapClientOptions);
    }
}
