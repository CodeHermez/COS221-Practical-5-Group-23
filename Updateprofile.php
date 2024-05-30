<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PATCH, OPTIONS");
header("Allow-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, Access-Control-Allow-Methods");

include_once 'config.php';
include_once "operations.php";

$database = Database::instance();
$dbc = $database->getConnection();
$data = json_decode(file_get_contents("php://input"), true);
//-------------------------------------------------------------------------------------------------------------------------------------

if($_SERVER['REQUEST_METHOD'] === "PATCH"){
   
    if (!isset($data['email']) && !isset($data['age']) && !isset($data['profile_picture']) && !isset($data['username'])) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Missing parameters"]);
        return;
    }


    $patchProfile = new UpdateProfile($dbc);
    $response = $patchProfile->changeProfile($data);

    header('Content-Type: application/json');
    echo $response;
}
else{
    echo json_encode(array("status" => "error", "timestamp" => time(), "data"=> "No such request type exists"));
    header("HTTP/1.1 404 Not Found");
    return;
}