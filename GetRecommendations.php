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
//$data = json_decode(file_get_contents("php://input"));
//-------------------------------------------------------------------------------------------------------------------------------------


if($_SERVER['REQUEST_METHOD'] === "GET")
{
    $usr_login = new getRecommendations($dbc);
    if(!isset($_GET['username']))
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Username is required"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }

    if($_GET['username'] === "")
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Username should not be empty"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }

    $usr_login->username = $_GET['username'];
    $rst = $usr_login->getRecommendations();
    if(!$rst)
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Error occurred while fetching data"));
        header("HTTP/1.1 500 Internal Server Error");
        return;
    }
    $size = $rst->rowCount();

    if($size > 0)
    {
        $final_data_arr = array("status"=>"success","timestamp"=>time(),"data"=>[]);
        while($r = $rst->fetch(PDO::FETCH_ASSOC))
        {
            extract($r);
            $item = array();
            if(isset($title))
                $item["title"] = $title;
            if(isset($genre))
                $item["genre"] = $genre;
            if(isset($release_Date))
                $item["release_date"] = $release_Date;
            if(isset($description))
                $item["description"] = $description;
            if(isset($content_rating))
                $item["content_rating"] = $content_rating;
            if(isset($rating) && $rating != null)
                $item["rating"] = $rating;

            array_push($final_data_arr["data"], $item);
        }
        echo json_encode($final_data_arr);
        return;
    }
    else {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Titles not found"));
        header("HTTP/1.1 404 Not Found");
        return;
    }

}
else
{
    echo json_encode(array("status" => "error", "timestamp" => time(), "data"=> "No such request type exists"));
    header("HTTP/1.1 404 Not Found");
    return;
}