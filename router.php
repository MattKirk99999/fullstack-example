<?php

/* Bootstrap the application. */

include 'App/Http/Request.php';
include 'App/Api.php';
include 'App/Controllers/CountriesController.php';
include 'App/Providers/RestCountriesEuService.php';

/* Route the request. */

use App\Http\Request;
use App\API;

$request = Request::Init();

if ($request->uri === "/")
{
    return false;
}
else if (preg_match('/\.(?:png|css|html|js)$/', $request->uri) && file_exists(__DIR__ . $request->uri)) 
{
    return false;
} 
else if (strpos ( $request->uri , "." ) === false)
{ 
    $api = new API();
    
    $apiResponse = $api->getResponse($request);
    
    header('Content-type: application/json');
    echo $apiResponse;
}
else
{
    require "page-not-found.html";
}