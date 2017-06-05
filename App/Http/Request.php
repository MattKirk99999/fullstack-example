<?php

namespace App\Http;

class Request
{
    public $uri;
    public $input;
    
    public static function Init()
    {
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
        
        $input = filter_input_array (INPUT_POST);
        
        return new Request($uri, $input);
    }
    
    public function __construct($uri, $input) 
    {
        $this->uri = $uri;
        $this->input = $input === null? array() : $input;
    }
    
    public function getInputs()
    {
        $ret = array();

        $args = func_get_args();

        foreach ($args as $key)
        {
            $ret[$key] = (array_key_exists($key, $this->input)) ? 
                    $this->input[$key] : null;
        }
        
        return $ret;
    }
}
