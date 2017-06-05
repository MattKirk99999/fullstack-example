<?php

namespace App;

use App\Http\Request;
use App\Controllers\CountriesController;

class API
{
    public $controller;
    
    public function __construct() 
    {
        $this->controller = new CountriesController();
    }

    public function getResponse(Request $request)
    {       
        try
        {
            switch ($request->uri)
            {
                case self::strBeginsWith($request->uri, "/api/v1/country/name"):
                    return json_encode ( $this->controller->getCountriesByName($request) );
                case self::strBeginsWith($request->uri, "/api/v1/country/fullname"):
                    return json_encode ( $this->controller->getCountriesByFullName($request) );
                case self::strBeginsWith($request->uri, "/api/v1/country/code"):
                    return json_encode ( $this->controller->getCountriesByCode($request) );
                case self::strBeginsWith($request->uri, "/api/v1/test"):
                    return json_encode( $request->input );
                default:
                    throw new \Exception("API route not found.");
            }
        }
        catch(\Exception $e)
        {
            http_response_code (400);
            return json_encode( ["error"=>$e->getMessage(), "request"=>$request->uri, "input"=>$request->input]);
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