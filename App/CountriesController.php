<?php

namespace App;

class CountriesController 
{
    public function getCountriesByName($request)
    {
        $inputs = $request->getInputs('query');

        $query = $inputs['query'];
        
        if ($query === null) 
        {
            return ["error"=>"No query entered.", "request"=>$request->uri, "input"=>$request->input];
        }
        
        try
        {
            $result = $this->restCountriesEuService("name", $query, false);
        }
        catch(\Exception $e)
        {
            return ["error"=>"The API had trouble with your request.", "request"=>$request->uri, "details"=>$e->getMessage()];
        }

        return $result;
    }
    
    public function getCountriesByFullName($request)
    {
        $inputs = $request->getInputs('query');

        $query = $inputs['query'];
        
        if ($query === null) 
        {
            return ["error"=>"No query entered.", "request"=>$request->uri, "input"=>$request->input];
        }
        
        try
        {
            $result = $this->restCountriesEuService("name", $query, true);
        }
        catch(\Exception $e)
        {
            return ["error"=>"The API had trouble with your request.", "request"=>$request->uri, "details"=>$e->getMessage()];
        }

        return $result;
    }
    
    public function getCountriesByCode($request)
    {
        $inputs = $request->getInputs('query');

        $query = $inputs['query'];
        
        if ($query === null) 
        {
            return ["error"=>"No query entered.", "request"=>$request->uri, "input"=>$request->input];
        }
        
        try
        {
            $result = $this->restCountriesEuService("alpha", $query, false);
        }
        catch(\Exception $e)
        {
            return ["error"=>"The API had trouble with your request.", "request"=>$request->uri, "details"=>$e->getMessage()];
        }

        return array($result);
    }
    
    private function restCountriesEuService($route, $query, $fullText)
    {
        // Configure our request.
        
        $baseUrl = "https://restcountries.eu/rest/v1/";
        
        $options = "";
        
        if ($fullText) 
        {
            $options .= "fullText=true";
        }
        
        // Init curl and set options.
        
        $ch = curl_init();

        $url = $baseUrl . $route . "/" . curl_escape( $ch, $query ) . "?" . $options;

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
