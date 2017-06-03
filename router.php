<?php

include 'Http/Request.php';
include 'api.php';

use Http\Request;


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
    $apiResponse = API::GetResponse($request);
    
    header('Content-type: application/json');
    echo $apiResponse;
}
else
{
    require "page-not-found.html";
}