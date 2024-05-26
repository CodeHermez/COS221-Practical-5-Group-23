<?php
// from here to the if statement you do not have to change the code unless you want add something else
// like more headers, but its pretty straight forward.
//-------------------------------------------------------------------------------------------------------------------------------------
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Allow-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, Access-Control-Allow-Methods");

include_once '../config.php';
include_once "../operations.php";

$database = Database::instance();
$dbc = $database->getConnection();
//$data = json_decode(file_get_contents("php://input"));
//-------------------------------------------------------------------------------------------------------------------------------------

if($_SERVER['REQUEST_METHOD'] === "DELETE")
{
    $delt_t = new deleteTitle($dbc);

    if(!isset($_GET['media_id']) || $_GET['media_id'] === "")
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "MediaID is required"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }

    $delt_t->media_id = intval($_GET['media_id']);

    if($delt_t->media_id === 0)
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "MediaID must be a number"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }

    if($delt_t->deleteTitle())
    {
        echo json_encode(array("status" => "success", "timestamp" => time(), "data" => "Title deleted successfully"));
        header("HTTP/1.1 200 OK");
        return;
    }
    else
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Title not deleted"));
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