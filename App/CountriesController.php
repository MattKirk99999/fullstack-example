<?php

namespace App;

use App\RestCountriesEuService;

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
            $service = new RestCountriesEuService("name", $query, false);
            $result = $service->execute();
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
            $service = new RestCountriesEuService("name", $query, true);
            $result = $service->execute();
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
            $service = new RestCountriesEuService("alpha", $query, false);
            $result = $service->execute();
        }
        catch(\Exception $e)
        {
            return ["error"=>"The API had trouble with your request.", "request"=>$request->uri, "details"=>$e->getMessage()];
        }

        return array($result);
    }
}
