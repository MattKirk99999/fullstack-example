<?php

namespace App;

use Http\Request;
use App\CountriesController;

class API
{
    public $controller;
    
    public function __construct() 
    {
        $this->controller = new CountriesController();
    }

    public function getResponse(Request $request)
    {       
        switch ($request->uri)
        {
            case self::strBeginsWith($request->uri, "/api/v1/country"):
                return json_encode ( $this->controller->getCountries($request) );
            case self::strBeginsWith($request->uri, "/api/v1/test"):
                return json_encode( $request->input );
            default:
                return json_encode( ["error"=>"API route not found.", "request"=>$request->uri] );
        }
    }
    
    private static function strBeginsWith($str, $search)
    {
        return substr($str, 0, strlen($search)) === $search;
    }
    
    private static function log($message)
    {
        // Not implementing this. I am worried that
        // it will be too system-specific.
    }
}