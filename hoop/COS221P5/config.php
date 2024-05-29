<?php
class Database{

//wheatley host
  private $host = "wheatley.cs.up.ac.za";
//localhost
    // private $host = "localhost";


// wheatley user
    private $user = "u22659812";
//localhost user
    // private $user = "root";


    // wheatley password
    private $pass = "2CZDPF7LRNV6ELPTJRYFCC66TUVWK7L6";
    // localhost password
    // private $pass = "";


    // wheately database name
   private $db_name = "u22659812_hoop";
// localhost database name
    // private $db_name = "hoop";


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
