<?php
// from here to the if statement you do not have to change the code unless you want add something else
// like more headers, but its pretty straight forward.
//-------------------------------------------------------------------------------------------------------------------------------------
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

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $create = new createTitle($dbc);

if(isset($data->title) && isset($data->description) && isset($data->genre) && isset($data->rating) && isset($data->content_rating) && isset($data->release_date) && (isset($data->duration) || isset($data->seasons)) && isset($data->crew) && isset($data->type))
{

    if($data->title === "" && $data->description === "" && $data->genre === "" && $data->rating === "" && $data->content_rating === "" && $create->release_date === "" && $data->duration === "" && $data->seasons === "" && $data->type === "")
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Fields should not be left blank"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }
        $create->title = $data->title;
        $create->description = $data->description;
        $create->genre = $data->genre;
    if(($data->rating < 0 || $data->rating > 5))
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Rating must be between 0 and 5"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }
    $create->rating = $data->rating;


    if(!($data->content_rating === "PG" || $data->content_rating === "PG 9" || $data->content_rating === "PG 13" || $data->content_rating === "13" || $data->content_rating === "16" || $data->content_rating === "18"))
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Content rating must be G, PG, PG-13, R, or NC-17"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }
    $create->content_rating = $data->content_rating;


    $create->release_date = $data->release_date;


    if($data->type !== "movie" && $data->type !== "series")
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Type must be either movie or series"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }
    if($data->type === "movie" && !isset($data->duration))
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "A Movie should have a duration"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }
    if($data->type === "series" && !isset($data->seasons))
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Series should have a number of seasons"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }
    if(isset($data->duration))
        $create->duration = $data->duration;
    if(isset($data->seasons))
        $create->seasons = $data->seasons;

    $create->type = $data->type;

    if(isset($data->crew->actors))
    {
        $create->actors = $data->crew->actors;
    }
    if(isset($data->crew->writers))
    {
        $create->writers = $data->crew->writers;
    }
    if(isset($data->crew->directors))
    {
        $create->directors = $data->crew->directors;
    }

    if($create->createTitle())
    {
        echo json_encode(array("status" => "success", "timestamp" => time(), "data" => "Title created successfully"));
        header("HTTP/1.1 201 Created");
    }
    else
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Title not created"));
        header("HTTP/1.1 400 Bad Request");
    }
    return;
}
else {
    echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "All fields are required with the exception of crew subfields"));
    header("HTTP/1.1 400 Bad Request");
    return;
}


}
else
{
    echo json_encode(array("status" => "error", "timestamp" => time(), "data"=> "Request not handled / No such request type exists"));
    header("HTTP/1.1 404 Not Found");
    return;
}