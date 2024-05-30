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
    $gt_lst = new getTitle($dbc);

    if((!(isset($data->return) && isset($data->limit))))
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Return and limit are required"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }

    if( $data->return === "" || gettype($data->limit) !== "integer" || $data->limit === 0)
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Return and limit should not be empty"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }



        $gt_lst->return = $data->return;
    $gt_lst->Return_Parameters();


    if(isset($data->order) && !isset($data->sort))
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "If order is set, then sort should also be set"));
        header("HTTP/1.1 400 Bad Request");
        return;
    }
    if(isset($data->sort) && !isset($data->order))
    {
            echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "If sort is set, then order should also be set"));
            header("HTTP/1.1 400 Bad Request");
            return;
    }
    if(isset($data->sort) && isset($data->order))
    {
        $gt_lst->sort = $data->sort;
        $gt_lst->order = $data->order;
    }



    if(isset($data->search) && $data->search !== "")
    {

        if(!(gettype($data->search) === "object"))
        {
            echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Search should be an object"));
            header("HTTP/1.1 400 Bad Request");
            return;
        }

        if(isset($data->search->type) && $data->search->type === "tvshow" && (isset($data->search->minduration) || isset($data->search->maxduration)))
        {
            echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "TV shows do not have duration"));
            header("HTTP/1.1 400 Bad Request");
            return;
        }

        if(isset($data->search->type) && $data->search->type === "movie" && (isset($data->search->maxseasons) || isset($data->search->minseasons)))
        {
            echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Movies do not have seasons"));
            header("HTTP/1.1 400 Bad Request");
            return;
        }

        $flag = false;
        $gt_lst->Where();
        if(isset($data->search->id))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->search_media_id = $data->search->id;
            $gt_lst->Search_media_id();
        }
        if(isset($data->search->title))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->search_title = $data->search->title;
            $gt_lst->Search_title();
        }
        if(isset($data->search->genre))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->search_genre = '%'.$data->search->genre.'%';
            $gt_lst->Search_genre();
        }
        if(isset($data->search->rating))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->search_rating = $data->search->rating;
            $gt_lst->Search_rating();
        }
        if(isset($data->search->content_rating))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->search_content_rating = $data->search->content_rating;
            $gt_lst->Search_content_rating();
        }
        if(isset($data->search->release_date))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->search_release_date = $data->search->release_date;
            $gt_lst->Search_release_date();
        }
        if(isset($data->search->cast))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->search_cast = '%'.$data->search->cast.'%';
            $gt_lst->Search_cast();
        }
        if(isset($data->search->director))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->search_director = '%'.$data->search->director.'%';
            $gt_lst->Search_director();
        }
        if(isset($data->search->writer))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->search_writer = $data->search->writer;
            $gt_lst->Search_writer();
        }
        if(isset($data->search->minduration))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->minDuration = $data->search->minduration;
            $gt_lst->MinDuration();
        }
        if(isset($data->search->maxduration))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->maxDuration = $data->search->maxduration;
            $gt_lst->MaxDuration();
        }
        if(isset($data->search->minseasons))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->minSeasons = $data->search->minseasons;
            $gt_lst->MinSeasons();
        }
        if(isset($data->search->maxseasons))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->maxSeasons = $data->search->maxseasons;
            $gt_lst->MaxSeasons();
        }
        if(isset($data->search->minrating))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->minRating = $data->search->minrating;
            $gt_lst->MinRating();
        }
        if(isset($data->search->maxrating))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->maxRating = $data->search->maxrating;
            $gt_lst->MaxRating();
        }
        if(isset($data->search->minreleasedate))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->minReleaseDate = $data->search->minreleasedate;
            $gt_lst->MinReleaseDate();
        }
        if(isset($data->search->maxreleasedate))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            $gt_lst->maxReleaseDate = $data->search->maxreleasedate;
            $gt_lst->MaxReleaseDate();
        }
        if(isset($data->search->type))
        {
            if($flag === false)
            {
                $flag = true;
            }
            else
            {
                $gt_lst->And();
            }
            if($data->search->type === "movie")
            {
                $gt_lst->search_type = "movie";
                $gt_lst->Search_type();
            }
            else if($data->search->type === "tvshow")
            {
                $gt_lst->search_type = "tvshow";
                $gt_lst->Search_type();
            }
            else
            {
                echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Type should be either movie or tvshow"));
                header("HTTP/1.1 400 Bad Request");
                return;
            }
        }

        $flag = false;
    }

    if(isset($data->sort) && isset($data->order) && $data->order != "" && $data->sort != "")
    {
        $gt_lst->sort = $data->sort;
        $gt_lst -> order = $data->order;
        $gt_lst -> SortAndOrder();
    }
    else if(isset($data->sort))
    {
        $gt_lst->sort = $data->sort;
        $gt_lst->Sort();
    }

    if(isset($data->limit))
    {
        $gt_lst->limit = $data->limit;
        $gt_lst->Limit();
    }

    $gt_lst->closeQuery();
    $rst = $gt_lst->executeQuery();
    if($rst===false)
    {
        echo json_encode(array("status" => "error", "timestamp" => time(), "data" => "Error executing query"));
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
            if(isset($media_ID))
                $item["id"] = $media_ID;
            if(isset($title))
                $item["title"] = $title;
            if(isset($poster_Url))
                $item["image"] = $poster_Url;
            if(isset($description))
                $item["description"] = $description;
            if(isset($duration))
                $item["duration"] = $duration;
            if(isset($seasons))
                $item["seasons"] = $seasons;
            if(isset($rating))
                $item["rating"] = $rating;
            if(isset($content_rating))
                $item["content_rating"] = $content_rating;
            if(isset($release_Date))
                $item["release_date"] = $release_Date;
            if(isset($Genre))
                $item["genre"] = explode(",", $Genre);
            if(isset($CAST))
                $item["cast"] = explode(",", $CAST);
            if(isset($DIRECTOR))
                $item["director"] = explode(",", $DIRECTOR);
            if(isset($WRITER))
                $item["writer"] = explode(",", $WRITER);
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