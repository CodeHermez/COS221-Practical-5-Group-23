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
    $addwishlst = new addWishlist($dbc);

    if(!isset($data->username) || $data->username === "")
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Username is required"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }

    $addwishlst->username = $data->username;

    if(isset($data->media_id) && !isset($data->title))
    {
        $addwishlst->media_id = $data->media_id;
        if($addwishlst->addWishlistWithMediaID())
        {
            echo json_encode(array("status" => "success", "timestamp" => time(), "data" => "Wishlist added successfully"));
            header("HTTP/1.1 200 OK");
            return;
        }
        else
        {
            echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Wishlist not added"));
            header("HTTP/1.1 500 Internal Server Error");
            return;

        }
    }
    else if(isset($data->title) && !isset($data->media_id))
    {
        $addwishlst->title = $data->title;
        if($addwishlst->addWishlistWithoutMediaID())
        {
            echo json_encode(array("status" => "success", "timestamp" => time(), "data" => "Wishlist added successfully"));
            header("HTTP/1.1 200 OK");
            return;
        }
        else
        {
            echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Wishlist not added"));
            header("HTTP/1.1 500 Internal Server Error");
            return;
        }
    }
    else
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "MediaID is required"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }


    // do what ever you must complete your job here

}
else
{
    echo json_encode(array("status" => "error", "timestamp" => time(), "data"=> "No such request type exists"));
    header("HTTP/1.1 404 Not Found");
    return;
}