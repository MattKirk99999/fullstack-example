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
            throw new \Exception("No query entered.");
        }
        
        $result = (new RestCountriesEuService("name", $query, false))->execute();

        return $this->sortAndPrune( $result );
    }
    
    public function getCountriesByFullName($request)
    {
        $inputs = $request->getInputs('query');

        $query = $inputs['query'];
        
        if ($query === null) 
        {
            throw new \Exception("No query entered.");
        }

        $result = (new RestCountriesEuService("name", $query, true))->execute();

        return $this->sortAndPrune( $result );
    }
    
    public function getCountriesByCode($request)
    {
        $inputs = $request->getInputs('query');

        $query = $inputs['query'];
        
        if ($query === null) 
        {
            throw new \Exception("No query entered.");
        }

        $result = (new RestCountriesEuService("alpha", $query, false))->execute();
        
        if ($result === array()) return $this->sortAndPrune( $result ); // handles odd corner-case.
        
        return $this->sortAndPrune(array($result));
    }
    
    private function sortAndPrune($countries, $maxSize = 50)
    {
        $size = min(count($countries), $maxSize);
        
        for( $i = 0; $i < $size; $i++)
        {
            $currCountry = $countries[$i];
            $currCountryName = strtolower($currCountry->name);
            $j = $i-1;
            
            while($j >= 0 && (
                     strtolower($countries[$j]->name) > $currCountryName
                    || (strtolower($countries[$j]->name) === $currCountryName
                             && $countries[$j]->population > $currCountry->population)))
            {
                $countries[$j+1] = $countries[$j];
                $j--;
            }
            
            $countries[$j+1] = $currCountry;
        }

        return array_splice($countries, 0, $size);
    }
}
