<?php

namespace App;

class CountriesController 
{
    public function getCountries($request)
    {
        $url = "https://restcountries.eu/rest/v1/all/";
                
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        curl_close($ch);

        if ($result === false)
        {
            self::log(curl_error($ch));

            return ["error"=>"API had trouble with your request.", "request"=>$request->uri];
        }
        else
        {
            return $result;
        }
    }
}
