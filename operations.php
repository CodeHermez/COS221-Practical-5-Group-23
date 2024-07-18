<?php

// in this file is where you'll create all your classes to help you do all your
// necessary operations or execute queries to the database and return the
// result to the end point


class UserLogin
{
    //set these variables in your end point
    //since they are all public
    public $password;
    public $salt;
    public $connection;
    public $username;

//    constructor takes in the database connection
    public function __construct($db)
    {
        $this->connection = $db;
    }

//down here is where all your functions will go in order to help complete your task
// for example:

    /*
    public function Login()
    {
        //since the value of the username was set inside end point publicly
        //there's no need to pass in the username into the Login function,
        //or you could its honestly up to you and what you feel comfortable with

        $query = "Select id, password from users where username = :usr;";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":usr", $this->username);
        $stmt->execute();
        return $stmt;
    }
    */

}

class createTitle
{
    private $connection;
    public $title;
    public $description;
    public $genre;
    public $rating;
    public $content_rating;
    public $release_date;
    public $duration;
    public $seasons;
    public $type;
    public $actors = null;
    public $writers = null;
    public $directors = null;
    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function createTitle()
    {
        //remember to sanitize your inputs
        //and validate them
        //before you insert them into the database
        // remember to check if the title already exists
        // before you insert it into the database
        //remember to check implement crew and genre from matt


        $query = "INSERT INTO entertainment_content (title, release_Date, description, content_rating, rating)  
                    VALUES (:title, :release_date, :description, :content_rating, :rating);";

        $stmt = $this->connection->prepare($query);
        $this->title = filter_var($this->title, FILTER_SANITIZE_STRING);
        $this->release_date = filter_var($this->release_date, FILTER_VALIDATE_INT);
        $this->description = filter_var($this->description, FILTER_SANITIZE_STRING);
        $this->content_rating = filter_var($this->content_rating, FILTER_SANITIZE_STRING);
        $this->rating = filter_var($this->rating, FILTER_VALIDATE_INT);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->release_date = intval(htmlspecialchars(strip_tags($this->release_date)));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->content_rating = htmlspecialchars(strip_tags($this->content_rating));
        $this->rating = intval(htmlspecialchars(strip_tags($this->rating)));


        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":release_date", $this->release_date);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":content_rating", $this->content_rating);
        $stmt->bindParam(":rating", $this->rating);


        $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);

        $media_id = $this->connection->lastInsertId();

        if($this->type == "movie")
        {
            $query = "INSERT INTO movie (media_ID, duration) VALUES (:media_id, :duration);";
            $stmt = $this->connection->prepare($query);
            $this->duration = filter_var($this->duration, FILTER_VALIDATE_INT);
            $this->duration = intval(htmlspecialchars(strip_tags($this->duration)));
            $stmt->bindParam(":media_id", $media_id);
            $stmt->bindParam(":duration", $this->duration);
            $stmt->execute();
        }
        else if($this->type == "tvshow")
        {
            $query = "INSERT INTO tvshow (media_ID, seasons) VALUES (:media_id, :seasons);";
            $stmt = $this->connection->prepare($query);
            $this->seasons = filter_var($this->seasons, FILTER_VALIDATE_INT);
            $this->seasons = intval(htmlspecialchars(strip_tags($this->seasons)));
            $stmt->bindParam(":media_id", $media_id);
            $stmt->bindParam(":seasons", $this->seasons);
            $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        }


        $actor = "actor";
        $writer = "writer";
        $director = "director";
        $query = "INSERT INTO crew (name, role) VALUES (:name, :role);";

        $stmt = $this->connection->prepare($query);
        if($this->actors!=null)
            foreach($this->actors as $actor_name)
            {
                $actor_name = filter_var($actor_name, FILTER_SANITIZE_STRING);
                $actor_name = htmlspecialchars(strip_tags($actor_name));
                $stmt->bindParam(":name", $actor_name);
                $stmt->bindParam(":role", $actor);
                $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
                $crew_id = $this->connection->lastInsertId();

                $query2 = "INSERT INTO involved_in (crewID, media_ID) VALUES (:crewID,:media_ID);";
                $stmt2 = $this->connection->prepare($query2);
                $stmt2->bindParam(":crewID", $crew_id);
                $stmt2->bindParam(":media_ID", $media_id);
                $stmt2->execute() or die("Error: " . $stmt2->errorInfo()[2]);
            }
        if($this->writers!=null)
            foreach($this->writers as $writer_name)
            {
                $writer_name = filter_var($writer_name, FILTER_SANITIZE_STRING);
                $writer_name = htmlspecialchars(strip_tags($writer_name));
                $stmt->bindParam(":name", $writer_name);
                $stmt->bindParam(":role", $writer);
                $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
                $crew_id = $this->connection->lastInsertId();

                $query2 = "INSERT INTO involved_in (crewID, media_ID) VALUES (:crewID,:media_ID);";
                $stmt2 = $this->connection->prepare($query2);
                $stmt2->bindParam(":crewID", $crew_id);
                $stmt2->bindParam(":media_ID", $media_id);
                $stmt2->execute() or die("Error: " . $stmt2->errorInfo()[2]);
            }
        if($this->directors!=null)
            foreach($this->directors as $director_name)
            {
                $director_name = filter_var($director_name, FILTER_SANITIZE_STRING);
                $director_name = htmlspecialchars(strip_tags($director_name));
                $stmt->bindParam(":name", $director_name);
                $stmt->bindParam(":role", $director);
                $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
                $crew_id = $this->connection->lastInsertId();

                $query2 = "INSERT INTO involved_in (crewID, media_ID) VALUES (:crewID,:media_ID);";
                $stmt2 = $this->connection->prepare($query2);
                $stmt2->bindParam(":crewID", $crew_id);
                $stmt2->bindParam(":media_ID", $media_id);
                $stmt2->execute() or die("Error: " . $stmt2->errorInfo()[2]);
            }

        $query = "SELECT genreID FROM genre WHERE genreName = :genre;";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":genre", $this->genre);
        $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        if($stmt->rowCount() == 0)
        {
            $query = "INSERT INTO genre (genreName) VALUES (:genre);";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":genre", $this->genre);
            $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        }
        else
        {
            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            $genre_id = $r["genreID"];
            $query2 = "INSERT INTO belongs (genreID, media_ID) VALUES (:genreID, :media_ID);";
            $stmt2 = $this->connection->prepare($query2);
            $stmt2->bindParam(":genreID", $genre_id);
            $stmt2->bindParam(":media_ID", $media_id);
            $stmt2->execute() or die("Error: " . $stmt2->errorInfo()[2]);
        }

        return true;
    }
}


class deleteTitle
{
    private $connection;
    public $media_id;
    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function deleteTitle()
    {
        $query = "DELETE FROM entertainment_content WHERE media_ID = :media_id;";
        $stmt = $this->connection->prepare($query);
        $this->media_id = filter_var($this->media_id, FILTER_VALIDATE_INT);
        $this->media_id = intval(htmlspecialchars(strip_tags($this->media_id)));
        $stmt->bindParam(":media_id", $this->media_id);
        $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        return $stmt->rowCount() > 0;
    }
}

class addUserGenre
{
    private $connection;
    public $genreName;
    public $username;
    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function addGenre()
    {
        $query = "SELECT genreID FROM genre WHERE genreName = ?;";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $this->genreName);
        $check = $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        $genreID = null;
        if($stmt->rowCount() > 0)
        {
            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            $genreID = $r["genreID"];
        }
        else
        {
            return false;
        }

        if($genreID === null)
            return false;

        $query = "INSERT INTO favourite_genre (username, genreID) VALUES (:username,:genreID)";
        $stmt = $this->connection->prepare($query);
        $stmt->username = filter_var($this->username, FILTER_SANITIZE_STRING);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":genreID", $genreID);
        $check = $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        return $check;
    }
}


class getRecommendations
{
    private $connection;
    public $username;
    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function getRecommendations()
    {
        $query = "SELECT title,GROUP_CONCAT(genreName) AS genre, release_Date, description, content_rating, rating  FROM entertainment_content
                    INNER JOIN belongs ON entertainment_content.media_ID = belongs.media_ID
                    LEFT JOIN genre ON belongs.genreID = genre.genreID
                    WHERE genre.genreID IN (
                        SELECT genreID FROM favourite_genre
                        INNER JOIN user on favourite_genre.username = user.username
                        WHERE user.username = ?
                        )
                    GROUP BY entertainment_content.media_ID
                    HAVING COUNT(belongs.media_ID) > 1
                    ORDER BY COUNT(belongs.media_ID) DESC;";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $this->username);
        $check = $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        if($check)
            return $stmt;
        else
            return false;
    }
}


class addWishlist
{
    private $connection;
    public $media_id;
    public $username;
    public $title;
    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function addWishlistWithMediaID()
    {
        $query = "INSERT INTO wants_to_watch (username, mediaID) VALUES (:username,:media_id);";
        $stmt = $this->connection->prepare($query);
        $this->media_id = filter_var($this->media_id, FILTER_VALIDATE_INT);
        $this->media_id = intval(htmlspecialchars(strip_tags($this->media_id)));
        $this->username = filter_var($this->username, FILTER_SANITIZE_STRING);
        $this->username = htmlspecialchars(strip_tags($this->username));

        $stmt->bindParam(":media_id", $this->media_id);
        $stmt->bindParam(":username", $this->username);
        $check = $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        return $check;
    }

    public function addWishlistWithoutMediaID()
    {
        $query = "SELECT media_ID FROM entertainment_content WHERE title = :title;";
        $stmt = $this->connection->prepare($query);
        $this->title = filter_var($this->title, FILTER_SANITIZE_STRING);
        $this->title = htmlspecialchars(strip_tags($this->title));
        $stmt->bindParam(":title", $this->title);
        $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if(isset($r["media_ID"]))
            $this->media_id = $r["media_ID"];
        else
            return false;

//        echo($this->media_id . " " . $this->username);
        $query = "INSERT INTO wants_to_watch (username, mediaID) VALUES (:username,:media_id);";
        $stmt = $this->connection->prepare($query);
        $this->media_id = filter_var($this->media_id, FILTER_VALIDATE_INT);
        $this->media_id = intval(htmlspecialchars(strip_tags($this->media_id)));
        $this->username = filter_var($this->username, FILTER_SANITIZE_STRING);
        $this->username = htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":media_id", $this->media_id);
        $check = $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        return $check;
    }
}


class getTitle
{
    private $connection;
    private $query;
    public $limit;
    public $sort;
    public $order;
    public $search;
    public $return;




    public $search_media_id, $search_title, $search_genre, $search_rating, $search_content_rating, $search_release_date, $search_type, $search_cast, $search_director, $search_writer;


    public function __construct($db)
    {
        $this->connection = $db;
    }





    public function Return_Parameters()
    {
        if($this->return === "*")
        {
            $this->query = "SELECT * FROM( SELECT e.media_ID, title, release_Date, description, content_rating, rating, GROUP_CONCAT(DISTINCT g.genreName) AS Genre, GROUP_CONCAT(DISTINCT CASE WHEN c.role = \'actor\' THEN c.name END) AS CAST, GROUP_CONCAT(DISTINCT CASE WHEN c.role = \'director\' THEN c.name END) AS DIRECTOR, GROUP_CONCAT(DISTINCT CASE WHEN c.role = \'writer\' THEN c.name END) AS WRITER FROM belongs AS b INNER JOIN entertainment_content AS e ON e.media_ID = b.media_ID LEFT JOIN genre AS g ON g.genreID = b.genreID INNER JOIN hoopdatabase.involved_in i on e.media_ID = i.media_ID LEFT JOIN hoopdatabase.crew c on i.crewID = c.crewID GROUP BY e.media_ID, i.media_ID ) AS list";
        }
        else
        {
            $this->query .= "SELECT ";
            $this->query .= join(", ", $this->return);
            $this->query .= " FROM(
    SELECT e.media_ID, title, release_Date, description, content_rating, rating,
           GROUP_CONCAT(DISTINCT g.genreName) AS Genre,
           GROUP_CONCAT(DISTINCT CASE WHEN c.role = 'actor' THEN c.name END) AS CAST,
           GROUP_CONCAT(DISTINCT CASE WHEN c.role = 'director' THEN c.name END) AS DIRECTOR,
           GROUP_CONCAT(DISTINCT CASE WHEN c.role = 'writer' THEN c.name END) AS WRITER
    FROM belongs AS b
    INNER JOIN entertainment_content AS e ON e.media_ID = b.media_ID
    LEFT JOIN genre AS g ON g.genreID = b.genreID
    INNER JOIN hoopdatabase.involved_in i on e.media_ID = i.media_ID
    LEFT JOIN hoopdatabase.crew c on i.crewID = c.crewID
    GROUP BY e.media_ID, i.media_ID
) AS list ";
        }
    }



    public function getTitle()
    {
        $query = "SELECT * FROM entertainment_content WHERE title = :title;";
        $stmt = $this->connection->prepare($query);
        $this->title = filter_var($this->title, FILTER_SANITIZE_STRING);
        $this->title = htmlspecialchars(strip_tags($this->title));
        $stmt->bindParam(":title", $this->title);
        $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        return $stmt;
    }



    public function executeQuery()
    {
        echo($this->query);
        $stmt = $this->connection->prepare($this->query);

        $this->limit = filter_var($this->limit, FILTER_VALIDATE_INT);
        $this->limit = intval(htmlspecialchars(strip_tags($this->limit)));
        $this->sort = filter_var($this->sort, FILTER_SANITIZE_STRING);
        $this->sort = htmlspecialchars(strip_tags($this->sort));
        $this->order = filter_var($this->order, FILTER_SANITIZE_STRING);
        $this->order = htmlspecialchars(strip_tags($this->order));
        $this->search = filter_var($this->search, FILTER_SANITIZE_STRING);
        $this->search = htmlspecialchars(strip_tags($this->search));
        $this->search_title = filter_var($this->search_title, FILTER_SANITIZE_STRING);
        $this->search_title = htmlspecialchars(strip_tags($this->search_title));
        $this->search_genre = filter_var($this->search_genre, FILTER_SANITIZE_STRING);
        $this->search_genre = htmlspecialchars(strip_tags($this->search_genre));
        $this->search_rating = filter_var($this->search_rating, FILTER_VALIDATE_INT);
        $this->search_rating = intval(htmlspecialchars(strip_tags($this->search_rating)));
        $this->search_content_rating = filter_var($this->search_content_rating, FILTER_SANITIZE_STRING);
        $this->search_content_rating = htmlspecialchars(strip_tags($this->search_content_rating));
        $this->search_release_date = filter_var($this->search_release_date, FILTER_VALIDATE_INT);
        $this->search_release_date = intval(htmlspecialchars(strip_tags($this->search_release_date)));
        $this->search_type = filter_var($this->search_type, FILTER_SANITIZE_STRING);
        $this->search_type = htmlspecialchars(strip_tags($this->search_type));
        $this->search_cast = filter_var($this->search_cast, FILTER_SANITIZE_STRING);
        $this->search_cast = htmlspecialchars(strip_tags($this->search_cast));
        $this->search_director = filter_var($this->search_director, FILTER_SANITIZE_STRING);
        $this->search_director = htmlspecialchars(strip_tags($this->search_director));
        $this->search_writer = filter_var($this->search_writer, FILTER_SANITIZE_STRING);
        $this->search_writer = htmlspecialchars(strip_tags($this->search_writer));
        $this->search_media_id = filter_var($this->search_media_id, FILTER_VALIDATE_INT);
        $this->search_media_id = intval(htmlspecialchars(strip_tags($this->search_media_id)));

//        echo($this->return);
//        echo ($this->limit);
//        echo ($this->sort);
//        echo($this->order);
//        echo($this->search_content_rating);
//        echo($this->search_release_date);


        $stmt->bindParam(":limit", $this->limit);
        $stmt->bindParam(":sort", $this->sort);
        $stmt->bindParam(":order", $this->order);
        $stmt->bindParam(":search_title", $this->search_title);
        $stmt->bindParam(":search_genre", $this->search_genre);
        $stmt->bindParam(":search_rating", $this->search_rating);
        $stmt->bindParam(":search_content_rating", $this->search_content_rating);
        $stmt->bindParam(":search_release_date", $this->search_release_date);
        $stmt->bindParam(":search_type", $this->search_type);
        $stmt->bindParam(":search_cast", $this->search_cast);
        $stmt->bindParam(":search_director", $this->search_director);
        $stmt->bindParam(":search_writer", $this->search_writer);
        $stmt->bindParam(":search_media_id", $this->search_media_id);

        $stmt->execute();
        return $stmt;
    }

    public function Where()
    {
        $this->query .= " WHERE ";
    }

    public function And()
    {
        $this->query .= " AND ";
    }

    public function Search_title()
    {
        $this->query .= " title = :search_title ";
    }

    public function Search_genre()
    {
        $this->query .= " Genre = '%:search_genre%' ";
    }

    public function Search_cast()
    {
        $this->query .= " CAST = '%:search_cast%' ";
    }

    public function Search_media_id()
    {
        $this->query .= " media_ID = :search_media_id ";
    }

    public function Search_director()
    {
        $this->query .= " DIRECTOR = '%:search_director%' ";
    }

    public function Search_writer()
    {
        $this->query .= " WRITER = '%:search_writer%' ";
    }

    public function Search_rating()
    {
        $this->query .= " rating = :search_rating ";
    }

    public function Search_content_rating()
    {
        $this->query .= " content_rating = :search_content_rating ";
    }

    public function Search_release_date()
    {
        $this->query .= " release_date = :search_release_date ";
    }

    public function Search_type()
    {
        $this->query .= " type = :search_type ";
    }

    public function Limit()
    {
        $this->query .= " LIMIT :limit ";
    }

    public function Sort()
    {
        $this->query .= " ORDER BY :sort ";
    }

    public function SortAndOrder()
    {
        $this->query .= " ORDER BY : sort :order ";
    }


    public function closeQuery()
    {
        $this->query .= ";";
    }

}
