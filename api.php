<?php

use Http\Request;

class API
{
    public static function GetResponse(Request $request)
    {       
        switch ($request->uri)
        {
            case self::strBeginsWith($request->uri, "/api/v1/country"):
                $url = "https://restcountries.eu/rest/v1/all/";
                
                $ch = curl_init($url);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                
                $result = curl_exec($ch);
                curl_close($ch);
                
                if ($result === false)
                {
                    self::log(curl_error($ch));
                    
                    return json_encode(["error"=>"API had trouble with your request.", "request"=>$request->uri]);
                }
                else
                {
                    return $result;
                }
            case self::strBeginsWith($request->uri, "/api/v1/test"):
                return json_encode( $request->input );
            default:
                return json_encode(["error"=>"API route not found.", "request"=>$request->uri]);
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