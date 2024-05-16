<?php

error_reporting(E_ALL); ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Allow-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, Access-Control-Allow-Methods");

include_once '../config.php';
include_once "../operations.php";

if($_SERVER['REQUEST_METHOD'] === "GET"){
    
    $usr_out = new Logout();
    $response =  $usr_out->handleLogout();

    switch ($usr_out->response_code){
        case 200:
            header('HTTP/1.1 200 OK');
            break;
        case 400:
            header('HTTP/1.1 400 Bad Request');
            break;
        default:
            break;
    }
    
    header('Content-Type: application/json');
    // echo json_encode($response);

    echo $response;
   

}
else{
    echo json_encode(array("status" => "error", "timestamp" => time(), "data"=> "No such request type exists"));
    header("HTTP/1.1 404 Not Found");
    return;
}

