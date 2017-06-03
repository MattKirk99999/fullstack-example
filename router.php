<?php

require "api.php";

$requestUri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);

if ($requestUri === "/")
{
    return false;
}
else if (preg_match('/\.(?:png|css|html|js)$/', $requestUri) && file_exists(__DIR__ . $requestUri)) 
{
    return false;
} 
else if (strpos ( $requestUri , "." ) === false)
{ 
    $apiResponse = API::GetResponse($requestUri);
    
    header('Content-type: application/json');
    echo $apiResponse;
}
else
{
    require "page-not-found.html";
}