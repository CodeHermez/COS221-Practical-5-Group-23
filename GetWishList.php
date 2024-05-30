<?php
// error_reporting(E_ALL); ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Allow-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, Access-Control-Allow-Methods");

include_once '../config.php';
include_once "../operations.php";

$database = Database::instance();
$dbc = $database->getConnection();
$data = json_decode(file_get_contents("php://input"), true);
//-------------------------------------------------------------------------------------------------------------------------------------


if($_SERVER['REQUEST_METHOD'] === "GET"){
    $gt_wshlst = new getWishlist($dbc);

    if(!isset($_GET["username"])){
        echo json_encode(array("status" => "error", "timestamp" => time(), "data"=> "No username provided"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }

    $gt_wshlst->username = $_GET["username"];

    $rst = $gt_wshlst->getWishlist();
    if($rst === false)
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data"=> "An error occurred while fetching wishlist items"));
        header("HTTP/1.1 500 Internal Server Error");
        return;
    }
    $size = $rst->rowCount();
    if($size > 0){
        $final_data_arr = array("status" => "success", "timestamp" => time(), "data" => []);
        while($r = $rst->fetch(PDO::FETCH_ASSOC)){
            extract($r);
            $item = array();
            $item["id"] = $media_ID;
            $item["title"] = $title;
            $item["release_Date"] = $release_Date;
            $item["description"] = $description;
            $item["content_rating"] = $content_rating;
            $item["image"] = $poster_Url;
            array_push($final_data_arr["data"], $item);
        }
        echo json_encode($final_data_arr);
    }
    else{
        echo json_encode(array("status" => "error", "timestamp" => time(), "data"=> "No wishlist items found"));
        header("HTTP/1.1 404 Not Found");
    }
}
else{
    echo json_encode(array("status" => "error", "timestamp" => time(), "data"=> "No such request type exists"));
    header("HTTP/1.1 404 Not Found");
    return;
}