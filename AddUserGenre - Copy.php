<?php
// from here to the if statement you do not have to change the code unless you want add something else
// like more headers, but its pretty straight forward.
//-------------------------------------------------------------------------------------------------------------------------------------
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Allow-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, Access-Control-Allow-Methods");

include_once 'config.php';
include_once "operations.php";

$database = Database::instance();
$dbc = $database->getConnection();
$data = json_decode(file_get_contents("php://input"));
//-------------------------------------------------------------------------------------------------------------------------------------


if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $usr_gnr = new addUserGenre($dbc);

    if(!(isset($data->username) || isset($data->genre)))
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Username and genre are required"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }

    if($data->username === "" || $data->genre === "")
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Username and genre should not be empty"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }

    $usr_gnr->username = $data->username;
    $usr_gnr->genreName = $data->genre;
    if($usr_gnr->addGenre())
    {
        echo json_encode(array("status" => "success", "timestamp" => time(), "data" => "Genre added successfully"));
        header("HTTP/1.1 200 OK");
        return;
    }
    else
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Genre could not be added"));
        header("HTTP/1.1 500 Internal Server Error");
        return;
    }
}
else
{
    echo json_encode(array("status" => "error", "timestamp" => time(), "data"=> "No such request type exists"));
    header("HTTP/1.1 404 Not Found");
    return;
}