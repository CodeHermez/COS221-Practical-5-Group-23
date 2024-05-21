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
