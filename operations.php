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

    public function __construct($db){
        $this->connection = $db;
    }

    public function createUser($data){
        $this->name = $data['name'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->age = $data['age'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null; 

        if (!$this->name || !$this->username || !$this->age || !$this->email || !$this->password) {
            http_response_code(400);
            return createJSONResponse("error", "All fields are required.");
        }
    
        //check if email and/or username exist
        $exists = $this->exists($this->username,  $this->email);
        if($exists['exists']==true){       
            http_response_code(400);
            return createJSONResponse("error", $exists['message']);
        }

        //structure checking
        $information = $this->valid($this->age, $this->email, $this->password );
        
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
                $_SESSION['loggedIn'] = true;
                setcookie('username', $this->username, time() + 3600, '/');
                http_response_code(200);
                $status = "success";
                $msg = ["username" => $this->username];
            }
            else{
                http_response_code(500); 
                $status = "error"; 
                $msg = $this->connection->error;
            }
        }
        else{
            http_response_code(400); 
            $status = "error"; //400
            $msg = $information['message'];
        }    

        unset($stmt);

        return createJSONResponse($status, $msg);
    }

    private function exists($username, $email){
        $flag = false; //assume user DNE
        $response="";

        $query = 'SELECT username, email FROM user WHERE username=? OR email=?';
        $stmt = $this->connection->prepare($query);

        //if stmt has no results then the user does not exist yet 
        
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        if($stmt->execute()){
            //if no matches return false
            if($stmt->rowCount() == 0){
                unset($stmt);
                return [
                    "exists" => false,
                    "message" => ""
                ];
            }

            $results = $stmt->fetch(PDO::FETCH_ASSOC);

            //check if only username matched
            if($results['username']===$username && $results['email']!=$email){
                unset($stmt);
                return [
                    "exists" => true,
                    "message" => "Username is taken."
                ];
            }

            //check if only email matched
            if($results['username']!=$username && $results['email']===$email){
                unset($stmt);
                return [
                    "exists" => true,
                    "message" => "Email is in use."
                ];
            }

            //check if both matched
            if($results['username']===$username && $results['email']===$email){
                unset($stmt);
                return [
                    "exists" => true,
                    "message" => "Username and email are in use."
                ];
            }
        }
        else{
            unset($stmt);
            return [
                "exists" => $flag,
                "message" => $stmt->error
            ];
        }
    }

    private function valid($age, $email, $password){
    
        //check that age is valid
        $ageValid = $this->validateUserInput($age, "age");
        if (!$ageValid["valid"]) {
            return ["valid" => false, "message" => $ageValid["errMsg"]];
        }

        //check that email is valid
        $emailValid = $this->validateUserInput($email, "email");
        if (!$emailValid["valid"]) {
            return ["valid" => false, "message" =>  $emailValid["errMsg"]];
        }

        //check that the password is valid
        $passwordValid = $this->validateUserInput($password, "password");
        if (!$passwordValid["valid"]) {
            return ["valid" => false, "message" =>  $passwordValid["errMsg"]];
        }

        return ["valid" => true, "message" => "Valid input"];
    }

    private function validateUserInput($var, $varType){
        $errMsg = null;
        $valid = true;

        switch($varType){
            case 'age':
                if(trim($var) < 0){
                    $valid = false;
                    $errMsg = "Age must be a positive integer.";
                } 
                break;

            case 'email':
                $info = $this->validEmail($var);
                if(!$info['valid']){
                    $valid = false;
                    $errMsg = $info['message'];
                }
                break;

            case 'password':
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

    private function validEmail($email){ 
        //check that the structure is valid - VALIDSTRUCT==TRUE ELSE FALSE
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return[
                "valid" => false,
                "message" => "Invalid structure for email."
            ];
        }
        return [
            "valid" => true,
            "message" => "Email structure is valid."
        ];
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
        $data="";
        $status = false;

        $requestData = json_decode(file_get_contents('php://input'), true);

        //check if email has been set
        //check if password has been set
        // if(empty(trim($requestData["email"]))){
        //     $info = [
        //         "status" => $status,
        //         "data" => "Please provide an email."
        //     ];
        //     return $info;
        // }
        // if(empty(trim($requestData["password"]))){ 
        //     // return createJSONResponse('error', "Please provide a password.");
        //     $info = [
        //         "status" => $status,
        //         "data" => "Please provide a password."
        //     ];
        //     return $info;
        // }

        $email = trim($requestData["email"]) ?? null;
        // $this->username = trim($requestData["username"]) ?? null;
        $password = trim($requestData["password"]) ?? null;

        if (!$email || !$password) {
            http_response_code(400);
            return createJSONResponse("error", "All fields are required.");
        }


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
            // $data = "Something went wrong. Please try again later.";

            // http_response_code(500); 
                // $status = "error"; //400
            $data = $this->connection->error;
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
                session_regenerate_id();
                $_SESSION["loggedIn"] = true;
                $data = "Login was successful.";
                setcookie("username", $this->username, time() + 3600, "/");
                http_response_code(200);
            }
            else{
                // http_response_code(400);
                // $this->response_code = 400;
                $_SESSION["loggedIn"] = false;
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
        if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true){
            $_SESSION= false; //wait
            session_unset();
            session_destroy();
            setcookie("username", "", time() - 3600, "/");
            http_response_code(200);
            return createJSONResponse("success", "Logout successful.");

        } else {
            http_response_code(401);
            return createJSONResponse("error", "You are not logged in."); 
        }
    
    }
}

class AddReview{  //restricted to a user who is logged in
    private $connection;
    private $starRating;
    private $comment;
    private $mediaID;
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
        if (!isset($_SESSION['loggedIn'])) {
            http_response_code(401);
            return createJSONResponse("error", "User is not logged in.");
        } 

        $this->starRating = $data['starRating'] ?? null;
        $this->mediaID = $data['mediaID'] ?? null;

        if(!$this->starRating || !$this->mediaID){    //star rating required?
            http_response_code(400);
            return createJSONResponse("error", "Missing parameters.");
        }

        // $username = $_COOKIE['username'];
        // $this->starRating = $data['starRating'];
        $this->comment = trim($data["comment"]) ?? null; 
        // $this->mediaID = $data['mediaID'];
        $this->username = $_COOKIE['username'];

        $query = 'INSERT INTO content_review (comments, starRating, mediaID) VALUES (?, ?, ?)';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $this->comment,  PDO::PARAM_STR); 
        $stmt->bindParam(2, $this->starRating, PDO::PARAM_INT);
        $stmt->bindParam(3, $this->mediaID, PDO::PARAM_INT);

        if(!$stmt->execute()){
            http_response_code(500);
            return createJSONResponse("error", $stmt->error);
        }

        //get review ID FROM CONTENT REIVEW
        $insert_id = $this->connection->lastInsertId();

        $query = 'INSERT INTO writes (reviewID, username) VALUES (?, ?)';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $insert_id,  PDO::PARAM_INT); 
        $stmt->bindParam(2, $this->username, PDO::PARAM_STR);

        if(!$stmt->execute()){
            //delete the insert into content_review
            $query2 = 'DELETE FROM content_review WHERE reviewID = ?';
            $stmt2 = $this->connection->prepare($query2);
            $stmt2->bindParam(1, $insert_id,  PDO::PARAM_INT);
            $stmt2->execute();

            return createJSONResponse("error", $stmt->error);
        }

        unset($stmt);

        // $this->code = 200; // OK
        http_response_code(200);
        return createJSONResponse("success", "Added review successfully");
    }
}

class GetReviews{  //no restrictoins //add filter and sort for star rating
    /* username
    
    mediaID*/
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
            // $this->username = $_COOKIE['username'];
            $query = 'SELECT title, starRating, comments FROM writes
            INNER JOIN content_review cr on writes.reviewID = cr.reviewID
            INNER JOIN entertainment_content ec on cr.mediaID = ec.mediaID
            WHERE username = ?
            LIMIT ?';

            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $data['username'],  PDO::PARAM_STR);
            $stmt->bindParam(2, $limit,  PDO::PARAM_INT);

            if($stmt->execute()){
                $resultArr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //check if anything was returnd
                if(count($resultArr)==0){
                    unset($stmt);
                    return createJSONResponse("error", "User, {$data['username']}, has not written any reviews.");
                }

                $response = []; //if this is returned then the user has no comments? 
                foreach($resultArr as $row){
                    $response[] = [
                        'title' => $row['title'],
                        'username' => $data['username'],
                        'starRating' => (float) $row['starRating'],
                        'comment' => $row['comments']
                    ];
                }
                unset($stmt);
                http_response_code(200);
                return createJSONResponse("success", $response);
            } 
            else{
                unset($stmt);
                http_response_code(500);
                createJSONResponse("error", $this->connection->error);
            }
        } 
        else{
            /*
                Get review based on media ID

                SELECT mediaID,title,username,starRating,comments FROM writes
                INNER JOIN hoop.content_review cr on writes.reviewID = cr.reviewID
                INNER JOIN hoop.entertainment_content ec on cr.mediaID = ec.mediaID
                WHERE mediaID = ?
                LIMIT ?;
            */
            //return body - for media
            /*
                comments[
                    0 -> {
                        mediaID => 
                        title =>
                        username => fjakjfa,
                        starRating => 4.5,
                        comment => 
                    }
                ]
            */

            $mediaID = $data['mediaID'];
            $limit= $data['limit'] ?? 20;  //default

            $query = 'SELECT mediaID,title,username,starRating,comments FROM writes
            INNER JOIN content_review cr on writes.reviewID = cr.reviewID
            INNER JOIN entertainment_content ec on cr.mediaID = ec.mediaID
            WHERE mediaID = ?
            LIMIT ?';

            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $mediaID,  PDO::PARAM_STR);
            $stmt->bindParam(2, $limit,  PDO::PARAM_INT);

            if($stmt->execute()){
                $resultArr = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if(count($resultArr)==0){
                    unset($stmt);
                    return createJSONResponse("error", "No reviews for media with the ID - {$mediaID}.");
                }

                foreach($resultArr as $row){
                    $response[] = [
                        'mediaID' => $row['mediaID'],
                        'title' => $row['title'],
                        'username' => $row['username'],
                        'starRating' => $row['starRating'],
                        'comment' => $row['comments']
                    ];
                }
                unset($stmt);
                http_response_code(200);
                return createJSONResponse("success", $response);
            }else{
                unset($stmt);
                http_response_code(500);
                createJSONResponse("error", $this->connection->error);
            }
        }
    }
}

class DeleteReview{ //restricted to a user who is logged in
    private $connection;
    // private $username; 
    //username
    //reviewID

    public function __construct($db){
        $this->connection = $db;
    }

    public function handleDeleteReview($data){ //frontend would have to ensure that users can only delete their own comments
        
        if(!isset($_SESSION['loggedIn'])){
            http_response_code(400);
            createJSONResponse("error", "User is not logged in.");
        }
        
        if((!isset($data['username']) || $data['username']==null) || (!isset($data['reviewID']) || $data['reviewID']==null)){  //at least one must be initialised
            //error
            http_response_code(400);
            return createJSONResponse("error", "Missing parameters.");
        }

        //delete specific comment
        if(isset($data['reviewID'])){
            $query = 'DELETE FROM writes WHERE reviewID = ?';
            $query2 = 'DELETE FROM content_review WHERE reviewID = ?';
            $stmt1 = $this->connection->prepare($query);
            $stmt2 = $this->connection->prepare($query2);

            $stmt1->bindParam(1, $data['reviewID'],  PDO::PARAM_INT);

            if($stmt1->execute()){

                if($stmt1->rowCount() == 0){
                    //nothing was deleted 
                    unset($stmt1);
                    http_response_code(400);
                    return createJSONResponse("error", "No deletions were made. Check reviewID.");
                }


                $stmt2->bindParam(1, $data['reviewID'],  PDO::PARAM_INT);

                if($stmt2->execute()){
                    if($stmt1->rowCount() == 0){
                        //nothing was deleted 
                        unset($stmt1);
                        unset($stmt2);
                        http_response_code(400);
                        return createJSONResponse("error", "No deletions were made. Check reviewID.");
                    }

                    unset($stmt1);
                    unset($stmt2);
                    http_response_code(200);
                    return createJSONResponse("success", "Review successfully deleted.");
                } else {
                    unset($stmt1);
                    unset($stmt2);
                    http_response_code(500); //?
                    return createJSONResponse("error", $this->connection->error); //review id ne in content_review??
                }
            } else {
                unset($stmt1);
                unset($stmt2);
                http_response_code(500);//?
                return createJSONResponse("error",$this->connection->error); //review id dne in writes?
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
    // private $username; //anyone will have this ability

    public function __construct($db){
        $this->connection = $db;
    }

    public function handleGetFriends($data){
        if (!isset($data['username']) || $data['username']==null) {
            http_response_code(400);
            return createJSONResponse("error", "Missing username parameter.");
        }

        try {
            $query = 'SELECT friendID FROM friend WHERE username=?';
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $data['username'],  PDO::PARAM_STR);

            if($stmt->execute()){
                $resultArr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                $response = [];
                foreach($resultArr as $row){
                    $response[] = [
                        'friendID' => $row['friendID']
                    ];
                }
                unset($stmt);
    
                http_response_code(200);
                return createJSONResponse("success", $response);
            }
            else{
                unset($stmt);
                http_response_code(500);
                return createJSONResponse("error", $this->connection->error); //??
            }
        } catch (PDOException $e) {
            unset($stmt);
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

class AddFriend{ //done
    /* usernameOrigin
    usernameFriend
    */

    private $connection;
    private $username;
 
    public function __construct($db){
        $this->connection = $db;
    }

    public function handleAddFriend($data){
        if(!isset($_COOKIE['username'])){
            http_response_code(400);
            return createJSONResponse("error", "User is not logged in.");
        }

        if(!isset($data['friendID'])){
            http_response_code(400);
            return createJSONResponse("error", "Missing parameter.");
        }

        try {
            $this->username = $_COOKIE['username'];
            $query = 'INSERT INTO friend (username, friendID) VALUES (?, ?)';
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $this->username,  PDO::PARAM_STR); 
            $stmt->bindParam(2, $data['friendID'], PDO::PARAM_STR);

            if($stmt->execute()){
                unset($stmt);
                http_response_code(200);
                return createJSONResponse("success", "Friend added successfully.");
            }
            else{ //could be unreachable
                unset($stmt);
                http_response_code(400);
                return createJSONResponse("error", "1" . $this->connection->error); //verify
            }
        } catch(PDOException $e){
            unset($stmt);
            http_response_code(500);
            return createJSONResponse("error",  "User, {$data['friendID']}, does not exist.");
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
        if(!isset($_COOKIE['username'])){
            http_response_code(400);
            return createJSONResponse("error", "User is not logged in.");
        }

        if(!isset($data['friendID']) || !isset($data['username'])){ //allows admin accounts to oversee removing friends as well as users
            http_response_code(400);
            return createJSONResponse("error", "Missing parameters.");
        }

        $this->username = $data['username'];
        $this->friend = $data['friendID'];

        //get confirmation on how friendship works
        $query = 'DELETE FROM friend WHERE (username = ? AND friendID = ?)'; // OR (username = ? AND friendID = ?)';

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $this->username, PDO::PARAM_STR);
        $stmt->bindParam(2, $this->friend, PDO::PARAM_STR);

        try {
            if($stmt->execute()){
                unset($stmt);
                http_response_code(200);
                return createJSONResponse("success", "{$data['friendID']} successfully removed from {$data['username']}'s friends.");
            }
            else{
                unset($stmt);
                http_response_code(500);
                return createJSONResponse("error", $this->connection->error);
            }
        } catch (PDOException $e) {
            unset($stmt);
            http_response_code(500);
            return createJSONResponse("error", $e->getMessage());
        }
    }

    
}

