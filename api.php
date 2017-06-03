<?php

class API
{
    public static function GetResponse($requestUri)
    {       
        switch ($requestUri)
        {
            case self::strBeginsWith($requestUri, "/api/v1/country"):
                $url = "https://restcountries.eu/rest/v1/all/";
                
                $ch = curl_init($url);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                
                $result = curl_exec($ch);
                curl_close($ch);
                
                if ($result === false)
                {
                    self::log(curl_error($ch));
                    
                    return json_encode(["error"=>"API had trouble with your request.", "request"=>$requestUri]);
                }
                else
                {
                    return $result;
                }
            default:
                return json_encode(["error"=>"API route not found.", "request"=>$requestUri]);
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