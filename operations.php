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

class AddReview{
    public $connection;
    
    public function __construct($db)
    {
        $this->connection = $db;
    }
}

