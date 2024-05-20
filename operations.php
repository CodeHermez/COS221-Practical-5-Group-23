<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function createJSONResponse($status, $returnArr){
    $return = [
        'status' => $status,
        'timestamp' => time()
    ];

    if($status=='error'){
        $return['message'] = $returnArr;
    }elseif($status=='success'){
        $return['data'] = [$returnArr];
    }

    return json_encode($return);
}

class Register{ 
    private $email;
    private $password;
    private $username;
    private $age;
    private $name;
    private $connection;
    // public $response_code;

    //    constructor takes in the database connection
    public function __construct($db){
        $this->connection = $db;
    }

    public function createUser(){
        
        $data = json_decode(file_get_contents("php://input"), true);
        $this->name = $data['name'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->age = $data['age'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null; //make sure to store it with the restirctions
    
        //check if user exists already
             //name, username, email, password
        if($this->exists($this->name, $this->username, $this->age, $this->email)){       
            // $this->response_code = 400; //??????
            http_response_code(400);
            $response = "User is already registered.";
            return createJSONResponse("error", $response);
        }

        $information = $this->valid($this->name, $this->username, $this->age, $this->email, $this->password );
        
        if($information["valid"]){
            //create the salt and add salt to password
            $salt = $this->getRandomString();
            $newPassword = $this->password . $salt;

            //hash password
            $hashedPassword = hash('sha256', $newPassword);
            
            //start creating the sql query to insert user to database
            $query = "INSERT INTO user (username, name, email, password, salt, age, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $this->username, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->name, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->email, PDO::PARAM_STR);
            $stmt->bindParam(4, $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(5, $salt, PDO::PARAM_STR);
            $stmt->bindParam(6, $this->age, PDO::PARAM_INT);

            if($stmt->execute()){ 
                $_SESSION['loggedIn'];
                setcookie('username', $this->username, time() + 3600, '/');
                // $this->response_code = 200;
                http_response_code(200);
                $status = "success";
                $msg = ["username" => $this->username];
            }
            else{
                http_response_code(500); 
                // $this->response_code = 400;
                $status = "error"; //400
                $msg = $this->connection->error;
            }
        }
        else{
            http_response_code(400); 
            // $this->response_code = 400;
            $status = "error"; //400
            $msg = $information['message'];
        }    

        unset($stmt);

        /*return [
            "status" => $status,
            "timestamp" => time(),
            "data" => $msg
        ];   */

        return createJSONResponse($status, $msg);
    }

    private function exists($name, $username, $age, $email){
        $query = 'SELECT * FROM user WHERE name=? AND username=? AND age=? AND email=?';
        $stmt = $this->connection->prepare($query);

        //if stmt has no results then the user does not exist yet 
        
        $stmt->bindParam(1, $name,  PDO::PARAM_STR);
        $stmt->bindParam(2, $username, PDO::PARAM_STR);
        $stmt->bindParam(3, $age, PDO::PARAM_INT);
        $stmt->bindParam(4, $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        unset($stmt);

        return ($result!=false); 
    }

    private function valid($name, $username, $age, $email, $password){
        //check that name is valid
        $nameValid = $this->validateUserInput($name, "name");
        if(!$nameValid["valid"]){
            return ["valid" => false, "message" => $nameValid["errMsg"]];
            // return createJSONResponse("error", $nameValid["errMsg"]);
        }

        //check that username is valid
        $usernameValid = $this->validateUserInput($username, "username");
        if (!$usernameValid["valid"]) {
            return ["valid" => false, "message" => $usernameValid["errMsg"]];
            // return createJSONResponse("error", $usernameValid["errMsg"]);
        }

        //check that age is valid
        $ageValid = $this->validateUserInput($age, "age");
        if (!$ageValid["valid"]) {
            return ["valid" => false, "message" => $ageValid["errMsg"]];
            // return createJSONResponse("error", $ageValid["errMsg"]);
        }

        //check that email is valid
        $emailValid = $this->validateUserInput($email, "email");
        if (!$emailValid["valid"]) {
            return ["valid" => false, "message" =>  $emailValid["errMsg"]];
            // return createJSONResponse("error", $emailValid["errMsg"]);
        }

        //check that the password is valid
        $passwordValid = $this->validateUserInput($password, "password");
        if (!$passwordValid["valid"]) {
            return ["valid" => false, "message" =>  $passwordValid["errMsg"]];
            // return createJSONResponse("error", $passwordValid["errMsg"]);
        }

        return ["valid" => true, "message" => "Valid input"];
        // return createJSONResponse("success", null);
    }

    private function validateUserInput($var, $varType){
        $errMsg = null;
        $valid = true;

        switch($varType){
            case 'name':
                if(trim($var) == ''){
                    $errMsg = "Name was not provided.";
                    $valid = false;
                    // $this->response_code = 400;
                }
                break;
            case 'username':
                if(trim($var) == ''){
                    $valid = false;
                    $errMsg = "Username was not provided.";
                    // $this->response_code = 400;
                    break;
                }
                $info = $this->validUsername($var);
                if(!$info['valid']){
                    $valid = false;
                    $errMsg = $info['message'];
                    // $this->response_code = 400;
                }
                break;

            case 'age':
                if(trim($var) == ''){
                    $valid = false;
                    $errMsg = "Age was not provided.";
                    // $this->response_code = 400;
                } 
                break;

            case 'email':
                if(trim($var) == ''){
                    $valid = false;
                    $errMsg = "Email was not provided.";
                    // $this->response_code = 400;
                    break;
                } 
                $info = $this->validEmail($var);

                if(!$info['valid']){
                    $valid = false;
                    $errMsg = $info['message'];
                    // $this->response_code = 400;
                }
                break;

            case 'password':
                if(trim($var) == ''){
                    $valid = false;
                    $errMsg = "Password was not provided.";
                    // $this->response_code = 400;
                    break;
                } 
                $info = $this->validPassword($var);

                if(!$info['valid']){
                    $valid = false;
                    $errMsg = $info['message'];
                }
                break;     
            default:
                $valid = false;
                $errMsg = "Unexpected variable: " . $var;
                // $this->response_code = 400;
        }

        $errorInfo = [
            "valid" => $valid,
            "errMsg" => $errMsg
        ];

        return $errorInfo;
    }

    private function validUsername($username){
        //check if the username already exists

        $exists = false;
        $flag = true;
        $msg = "";

        $query = "SELECT username FROM user WHERE username=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $username,  PDO::PARAM_STR);

        if($stmt->execute()){   //statement was executed
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $exists = ($result!=false);

            if($exists){
                $flag = false;  
                $msg = "Username has been taken.";
                // $this->response_code = 400;
            }
        }
        else{
            $flag = false;
            // $msg = "Server Error. Try again later.";
            // $this->response_code = 500;
            // http_response_code(500); 
            // $this->response_code = 400;
            // $status = "error"; //400
            $msg = $this->connection->error;
        }

        unset($stmt);
        

       $info = [
            "valid"=>$flag,
            "message" => $msg
        ];

        return $info;
    }

    private function validPassword($password){
        //check that it meets the requirements
        // 1 at least 8 characters long
        // 2 does it have an upper case character
        // 3 does it have a lower case charactyer
        // 4 is there at least one digit
        // 5 is there at least one symbol

        //approach
        //check if it is 8 characters long
        //if yes -do all the other checks
        //no? error msg

        if(strlen($password) >= 8){
            $msg="";
            $flag=true; //assume everythging is fine

            //check for uppercase
            if(!preg_match('/[A-Z]/', $password)){
                $flag = false;
                $msg .= "Password must contain at least one uppercase letter.\n";
            }

            //check for lowercase
            if(!preg_match('/[a-z]/', $password)){
                $flag = false;
                $msg .= "Password must contain at least one lowercase letter.\n";
            }
            
            //check for a digit
            if(!preg_match('/\d/', $password)){
                $flag = false;
                $msg .= "Password must contain at least one digit.\n";
            }

            //check for a symbol
            if(!preg_match('/[^A-Za-z0-9\s]/', $password)){
                $flag = false;
                $msg .= "Password must contain at least one symbol.\n";
            }

            if($flag===true){   //password structure is valid
                $msg = "Valid password";
            }

        }
        else{
            $flag = false;
            $msg = "Password must be at least 8 characters.";
            // $this->response_code = 400;
        }

        $info = [
            "valid" => $flag,
            "message" => $msg
        ];

        return $info;
    }

    private function validEmail($email){ //change this - dont user reg expression
        //check that it doesnt already exist in the database - DNE==TRUE ELSE FALSE
        //check that the structure is valid - VALIDSTRUCT==TRUE ELSE FALSE

        $exists = false;
        $flag = true;
        $msg = "";

        $query = "SELECT email FROM user WHERE email=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $email,  PDO::PARAM_STR);

        if($stmt->execute()){   //statement was executed
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $exists = ($result!=false);

            if(!$exists){
                // $re = '/^[A-Za-z0-9\x{0430}-\x{044F}\x{0410}-\x{042F}\._-]+@([A-Za-z0-9\x{0430}-\x{044F}\x{0410}-\x{042F}]{1,2}|[A-Za-z0-9\x{0430}-\x{044F}\x{0410}-\x{042F}]((?<!(\.\.))[A-Za-z0-9\x{0430}-\x{044F}\x{0410}-\x{042F}.-])+[A-Za-z0-9\x{0430}-\x{044F}\x{0410}-\x{042F}])\.[A-Za-z\x{0430}-\x{044F}\x{0410}-\x{042F}]{2,}$/iu';
                // if(preg_match($re, $email)!==1){
                //     // $validStructure =false;

                //     $flag = false;
                //     $msg = "Invalid structure for email.";
                // }

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $flag = false;  
                    $msg = "Invalid structure for email.";
                    // $this->response_code = 400;
                }
            }
        }
        else{
            $flag = false;
            // $msg = "Server error. Try again later.";
            // $this->response_code = 500;

            // http_response_code(500); 
            // $this->response_code = 400;
            // $status = "error"; //400
            $msg = $this->connection->error;
        }

        unset($stmt);
        

       $info = [
            "valid"=>$flag,
            "message" => $msg
        ];

        return $info;
    }

    private function getRandomString(){
        //generate unique alphanumeric string (64) and return it
        $string =  bin2hex(random_bytes(32));
        return $string;
    }
}

class Login{ 
    //set these variables in your end point
    //since they are all public
    public $password;
    public $salt;
    private $connection;
    public $username;
    private $email;
    public $response_code;

    /*email
    password
    */

    //    constructor takes in the database connection
    public function __construct($db){
        $this->connection = $db;
    }

    private function validCredentials(){
        // global $conn;
        $data="";
        $status = false;

        $requestData = json_decode(file_get_contents('php://input'), true);

        //check if email has been set
        //check if password has been set
        if(empty(trim($requestData["email"]))){
            // return createJSONResponse('error', "Please provide an email.");
            $info = [
                "status" => $status,
                "data" => "Please provide an email."
            ];
            return $info;
        }

        if(empty(trim($requestData["password"]))){ 
            // return createJSONResponse('error', "Please provide a password.");
            $info = [
                "status" => $status,
                "data" => "Please provide a password."
            ];
            return $info;
        }

        $email = trim($requestData["email"]);

        //check if email exits in db
        // if($this->exists($email)){
        $password = trim($requestData["password"]);

        $query = 'SELECT salt, password, username, name FROM user WHERE email=?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $email,  PDO::PARAM_STR);
        
        if($stmt->execute()){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            //check if results returned anything
            if ($results !== false) {
                // $results contains data, proceed with accessing its elements
                $dbPassword = $results['password'];
                $salt_and_password = $password . $results['salt'];
                $hashedPassword = hash('sha256', $salt_and_password);

                if($dbPassword==$hashedPassword){
                    // session_start();
                    // $_SESSION["loggedIn"] = true;
                    //set cookies
                    $this->username = $results['username'];

                    $status = true;
                }
                else{
                    $data = "Invalid email or password.";
                }
                
            } else {
                $data = "Invalid email or password.";
            }         
        }
        else{
            //500?
            $data = "Something went wrong. Please try again later.";
        }

        unset($stmt);

        //return error message and status (true or false)
        $info = [
            "status" => $status,
            "data" => $data
        ];
        return $info;
    }

    public function handleLogin(){

        if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true){

            // exit;
            // http_response_code(400);
            // $response =  [
            //     'status' => 'error',
            //     'timestamp' => time(),
            //     'data' => [
            //         "You are already logged in."
            //     ]
            // ];

            // $this->response_code = 400;
            http_response_code(400);
            $msg = "You are already logged in.";

            return createJSONResponse('error', $msg);
        } else{
            $status="";
            $data="";

  
            //send to validRequest
            $credentialsValid = $this->validCredentials();
            //if validRequest is true

            if($credentialsValid['status']==true){
                $status = "success";
                $_SESSION["loggedIn"] = true;
                $data = "Login was successful.";
                setcookie("username", $this->username, time() + 3600, "/");
                http_response_code(200);
            }
            else{
                // http_response_code(400);
                // $this->response_code = 400;
                http_response_code(400);
                if (session_status() === PHP_SESSION_ACTIVE) {
                    session_destroy();
                }
                $status = "error";
                $data = $credentialsValid['data'];
            }
        }

        return createJSONResponse($status, $data);
    }
}

class Logout{

    // public $response_code;

    public function handleLogout(){
        // session_start();
        setcookie("username", "", time() - 3600, "/");
        if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true){

            $_SESSION['loggedIn'] = false;
            $_SESSION = array();
        
            session_destroy();
            // $response_code = 200;
            http_response_code(200);
            return createJSONResponse("success", "Logout successful.");

        } else {
            // $response_code = 400; ////hmmmmmm
            http_response_code(403); //????
            return createJSONResponse("error", "You are not logged in."); 
        }
    
    }
}

class AddReview{  
    private $connection;
    private $star_rating;
    private $comment;
    private $media_id;
    private $username;
    // public $code;

    public function __construct($db){
        $this->connection = $db;
    }

    public function handleAddReview($data){
        /*
            INSERT INTO content_review(comments, starRating, mediaID) VALUES (?,?,?);
            #$sql->insert_id;
            INSERT INTO writes(reviewID, username) VALUES (?,?);
        */

        //check is username is set
        if (!isset($_COOKIE['username'])) {
            // $this->code = 403; // forbidden
            http_response_code(403);
            return createJSONResponse("error", "User is not logged in.");
        } 

        if(!isset($data['mediaID']) ||!isset($data['star_rating'])){    //star rating required?
            // $this->code = 400; //bad request
            http_response_code(400);
            return createJSONResponse("error", "Missing parameters.");
        }

        // $username = $_COOKIE['username'];
        $this->star_rating = $data['starRating'];
        $this->comment = $data['comment']; 
        $this->media_id = $data['mediaID'];
        $this->username = $_COOKIE['username'];

        $query = 'INSERT INTO content_review (comments, starRating, mediaID) VALUES (?, ?, ?)';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $this->comment,  PDO::PARAM_STR); 
        $stmt->bindParam(2, $this->star_rating, PDO::PARAM_INT);
        $stmt->bindParam(3, $this->media_id, PDO::PARAM_INT);

        if(!$stmt->execute()){
            http_response_code(500);
            return createJSONResponse("error", "Internal server error.");
        }

        //get review ID FROM CONTENT REIVEW
        $insert_id = $this->connection->lastInsertId();

        $query = 'INSERT INTO writes (reviewID, username) VALUES (?, ?)';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $insert_id,  PDO::PARAM_INT); //text
        $stmt->bindParam(2, $this->username, PDO::PARAM_STR);

        if(!$stmt->execute()){
            return createJSONResponse("error", "Internal server error.");
        }

        // $this->code = 200; // OK
        http_response_code((200));
        return createJSONResponse("success", "");
    }
}

class GetReviews{  
    /* username
    
    media_ID*/
    private $connection;
    private $username;
 
    public function __construct($db){
        $this->connection = $db;
    }

    public function handleGetReviews($data){

        if(!isset($data['username']) && !isset($data['mediaID'])){  //at least one must be initialised
            //error
            http_response_code(400);
            return createJSONResponse("error", "Missing parameters.");
        }
        
        if(isset($data['username'])){

             //return body - client
                /*
                    comments[
                        {
                            title : ,
                            username : ,
                            starRating : ,
                            comment: 
                        }
                        {
                            title : ,
                            username : ,
                            starRating : ,
                            comment: 
                        }
                        {
                            title : ,
                            username : ,
                            starRating : ,
                            comment: 
                        }
                    ]
                */
        
            $limit= $data['limit'] ?? 20;  //default
            $this->username = $_COOKIE['username'];
            $query = 'SELECT title, starRating, comments FROM writes
            INNER JOIN content_review cr on writes.reviewID = cr.reviewID
            INNER JOIN entertainment_content ec on cr.mediaID = ec.media_ID
            WHERE username = ?
            LIMIT ?';

            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $this->username,  PDO::PARAM_STR);
            $stmt->bindParam(2, $limit,  PDO::PARAM_INT);

            if($stmt->execute()){
                $resultArr = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $response = []; //if this is returned then the user has no comments? 
                foreach($resultArr as $row){
                    $response[] = [
                        'title' => $row['title'],
                        'username' => $row['username'],
                        'starRating' => $row['starRating'],
                        'comment' => $row['comments']
                    ];
                }

                http_response_code(200);
                return createJSONResponse("success", $response);
            } 
            else{
                http_response_code(500);
                createJSONResponse("error", "Internal Server Error");
            }
        } 
        else{
            /*
                Get review based on media ID

                SELECT media_ID,title,username,starRating,comments FROM writes
                INNER JOIN hoop.content_review cr on writes.reviewID = cr.reviewID
                INNER JOIN hoop.entertainment_content ec on cr.mediaID = ec.media_ID
                WHERE media_ID = ?
                LIMIT ?;
            */
            //return body - for media
            /*
                comments[
                    0 -> {
                        mediaID => 
                        title =>
                        username => fjakjfa,
                        star_rating => 4.5,
                        comment => 
                    }
                ]
            */

            $this->username = $_COOKIE['username'];
            $limit= $data['limit'] ?? 20;  //default

            $query = 'SELECT media_ID,title,username,starRating,comments FROM writes
            INNER JOIN content_review cr on writes.reviewID = cr.reviewID
            INNER JOIN entertainment_content ec on cr.mediaID = ec.media_ID
            WHERE media_ID = ?
            LIMIT ?';

            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $this->username,  PDO::PARAM_STR);
            $stmt->bindParam(2, $limit,  PDO::PARAM_INT);

            if($stmt->execute()){
                $resultArr = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($resultArr as $row){
                    $response[] = [
                        'media_ID' => $row['media_ID'],
                        'title' => $row['title'],
                        'username' => $row['username'],
                        'starRating' => $row['starRating'],
                        'comment' => $row['comments']
                    ];
                }
                http_response_code(200);
                return createJSONResponse("success", $response);
            }else{
                http_response_code(500);
                createJSONResponse("error", "Internal Server Error");
            }
        }
    }
}

class DeleteReview{
    private $connection;
    private $username;
    //username
    //reviewID

    public function __construct($db){
        $this->connection = $db;
    }

    public function handleDeleteReview(){
        if(!isset($data['username']) && !isset($data['reviewID'])){  //at least one must be initialised
            //error
            http_response_code(400);
            return createJSONResponse("error", "Missing parameters.");
        }

        //delete specific comment
        if(isset($data['reviewID'])){
            $query = 'DELETE FROM writes reviewID = ?';
            $query2 = 'DELETE FROM content_review WHERE reviewID = ?';
            $stmt1 = $this->connection->prepare($query);
            $stmt2 = $this->connection->prepare($query2);

            $stmt1->bindParam(1, $data['reviewID'],  PDO::PARAM_INT);

            if($stmt1->execute()){
                $stmt1->bindParam(2, $data['reviewID'],  PDO::PARAM_INT);

                if($stmt2->execute()){
                    http_response_code(200);
                    return createJSONResponse("success", "Review successfully deleted.");
                } else {
                    http_response_code(500); //?
                    return createJSONResponse("error", "Failed to delete from content_review."); //review id ne in content_review??
                }
            } else {
                http_response_code(500);//?
                return createJSONResponse("error", "Failed to delete from writes"); //review id dne in writes?
            }
        }
    }


    /*
        DELETE FROM writes WHERE reviewID = ?;
        DELETE FROM content_review where reviewID = ?;
            #OR
            DELETE FROM writes WHERE username = ?;
            DELETE FROM content_review WHERE reviewID NOT IN (
                SELECT writes.reviewID FROM writes
                );
    */
    


}

class GetFriends{ //get request
    //usernameOrigin
    private $connection;
    private $username; //not all logged in user will have this ability

    public function __construct($db){
        $this->connection = $db;
    }

    public function handleGetFriends($data){
        $this->username = $data['username'];

        $query = 'SELECT friendID FROM friend WHERE username=?';

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $this->username,  PDO::PARAM_STR);

        try {
            if($stmt->execute()){
                $resultArr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                $response = [];
                foreach($resultArr as $row){
                    $response[] = [
                        'friendID' => $row['friendID']
                    ];
                }
    
                http_response_code(200);
                return createJSONResponse("success", $response);
            }
            else{
                http_response_code(500);
                return createJSONResponse("error", "User does not exist."); //??
            }
        } catch (PDOException $e) {
            http_response_code(500);
            return createJSONResponse("error", $e->getMessage());
        }
    }


    /*return
    data[
        {
            username
        }, 
        {
            username
        }, 
        {
            username
        }
    ]

    */
}

class AddFriend{
    /* usernameOrigin
    usernameFriend
    */

    private $connection;
    private $username;
 
    public function __construct($db){
        $this->connection = $db;
    }

    public function handleAddFriend($data){
        if (!isset($_COOKIE['username']) || $data['friendID']) {
            http_response_code(403);
            return createJSONResponse("error", "User is not logged in or friendID was not provided."); //get a better error message
        } 

        $this->username = $_COOKIE['username'];
        $query = 'INSERT INTO friend (username, friendID) VALUES (?, ?)';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $this->username,  PDO::PARAM_STR); 
        $stmt->bindParam(2, $data['friendID'], PDO::PARAM_STR);

        try {
            if($stmt->execute()){
                http_response_code(200);
                return createJSONResponse("success", "Friend added successfully.");
            }
            else{
                http_response_code(400);
                return createJSONResponse("error", "User, {$data['friendID']}, does not exist."); //verify
            }
        } catch(PDOException $e){
            http_response_code(500);
            return createJSONResponse("error", $e->getMessage());
        }
    }
}

class RemoveFriend{
    /*usernameOrigin
    - usernameFriend
    */

    private $connection;
    private $username;
    private $friend;
    //username
    //reviewID

    public function __construct($db){
        $this->connection = $db;
    }

    public function handleRemoveFriend($data){
        if(!isset($_COOKIE['username']) || !isset($data['friendID'])){  //both must be initialised
            //error
            http_response_code(400);
            return createJSONResponse("error", "Missing parameters.");
        }

        $this->username = $_COOKIE['username'];
        $this->friend = $data['friendID'];

        //get confirmation on how friendship works
        $query = 'DELETE FROM friend WHERE (username = ? AND friendID = ?)'; // OR (username = ? AND friendID = ?)';

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $this->username, PDO::PARAM_STR);
        $stmt->bindParam(2, $this->friend, PDO::PARAM_STR);

        try {
            if($stmt->execute()){
                http_response_code(200);
                return createJSONResponse("success", "{$data['friendID']} successfully removed.");
            }
            else{
                http_response_code(500);
                return createJSONResponse("error", "User, {$data['friendID']} does not exist.");
            }
        } catch (PDOException $e) {
            return createJSONResponse("error", $e->getMessage());
        }
    }

    
}