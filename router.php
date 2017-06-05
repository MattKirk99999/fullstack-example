<?php

/* Bootstrap the application. */

include 'Http/Request.php';
include 'App/Api.php';
include 'App/CountriesController.php';

/* Route the request. */

use Http\Request;
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