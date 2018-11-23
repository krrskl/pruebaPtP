<?php
namespace App\Http\Controllers;

class BaseSoapController extends Controller
{
    protected static $options;
    protected static $context;

    protected static function generateContext()
    {
        self::$options = array(
            'http' => array(
                'user_agent' => 'PHPSoapClient',
            ),
        );
        return self::$context = stream_context_create(self::$options);
    }
}
