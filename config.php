<?php
class Database
{

    // you can comment these out uncomment them as you see fit
    // this is what i used to transition from wheatley to localhost
    // without having to retype stuff every time i switch
    // just uncomment and comment ;-)
    // this should work as far as im concerned fine



//wheatley host
//    private $host = "wheatley.cs.up.ac.za";
//localhost
    private $host = "localhost";


//wheatley user
//    private $user = "uXXXXXXXXXX";
//localhost user
    private $user = "root";


    // wheatley password
//    private $pass = "ABCDEFGHIJKLMENOPQRSTUVWZYZ";
    // localhost password
    private $pass = "";


    // wheately database name
//    private $db_name = "HOOT_MOVIES";
// localhost database name
    private $db_name = "auction";

    private $connection;
    private function __construct()
    {
        $this->connection = null;
        try {
            $this->connection = new PDO("mysql:host=" . $this->host. ";" . "dbname=" . $this->db_name . ";", $this->user, $this->pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e){
            echo "Connection error: ". $e->getMessage();
        }
    }

    public static function instance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new Database();
        }
        return $instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

}
