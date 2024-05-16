<?php
error_reporting(E_ALL); ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Allow-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, Access-Control-Allow-Methods");

include_once '../config.php';
include_once "../operations.php";

$database = Database::instance();
$dbc = $database->getConnection();
$data = json_decode(file_get_contents("php://input"));
//-------------------------------------------------------------------------------------------------------------------------------------

if($_SERVER['REQUEST_METHOD'] === "POST"  && $data->type === "Register"){
    $usr_rgst = new Register($dbc);
    $response =  $usr_rgst->createUser();

    switch ($usr_rgst->response_code){
        case 200:
            header('HTTP/1.1 200 OK');
            break;
        case 400:
            header('HTTP/1.1 400 Bad Request');
            break;
        case 500:
            header('HTTP/1.1 500 Internal Server Error');
            break;
        default:
            break;
    }

    header('Content-Type: application/json');
    echo $response;
}
else{
    echo json_encode(array("status" => "error", "timestamp" => time(), "data"=> "No such request type exists"));
    header("HTTP/1.1 404 Not Found");
    return;
}