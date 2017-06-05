<?php

namespace App;

class RestCountriesEuService 
{
    private $route, $query, $fullText;
    
    public function __construct($route, $query, $fullText) 
    {
        $this->route = $route;
        $this->query = $query;
        $this->fullText = $fullText;
    }
    
    public function execute()
    {
        return $this->restCountriesEuService();
    }
    
    private function restCountriesEuService()
    {
        // Configure our request.
        
        $baseUrl = "https://restcountries.eu/rest/v1/";
        
        $options = "";
        
        if ($this->fullText) 
        {
            $options .= "fullText=true";
        }
        
        // Init curl and set options.
        
        $ch = curl_init();

        $url = $baseUrl . $this->route . "/" . curl_escape( $ch, $this->query ) . "?" . $options;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute curl, throw exception on failure.
        
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 404)
        {
            $result = "[]";
        }
        else if ($httpCode === 400)
        {
            throw new \Exception("Trouble parsing query.");
        }
        else if ($result === false)
        {
            throw new \Exception("Had trouble fetching data.");
        }

        return json_decode($result);
    }
}
