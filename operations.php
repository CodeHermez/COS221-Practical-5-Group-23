<?php
// error_reporting(E_ALL); ini_set('display_errors', 1);
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
        $return['data'] = $returnArr;
    }

    return json_encode($return);
}

class Register{ //user input
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
        $this->name = htmlspecialchars($data['name'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $this->username = htmlspecialchars($data['username'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $this->age = filter_var($data['age'] ?? '', FILTER_VALIDATE_INT);
        $this->email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $this->password = htmlspecialchars($data['password'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');

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
                $_SESSION['username'] = $this->username;
                http_response_code(200);
                $status = "success";
                $msg = ["username" => $this->username,
                    "profile_picture" => 1
                ];

                return createJSONResponse($status, $msg);
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
                "exists" => "",
                "message" => ""
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
                if($var < 13){
                    $valid = false;
                    $errMsg = "User must be at least 13 years old.";
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

class Login{ //user input
    public $password;
    public $salt;
    private $connection;
    private $username;
    private $profilePic;

    /*email
    password
    */

    public function __construct($db){
        $this->connection = $db;
    }

    private function validCredentials(){
        $data="";
        $status = false;

        $requestData = json_decode(file_get_contents('php://input'), true);

        $email = filter_var($requestData["email"] ?? '', FILTER_SANITIZE_EMAIL);
        $this->password = $requestData["password"] ?? '';


        if (!$email || !$this->password) {
            return [
                "status" => $status,
                "data" => "All fields are required."
            ];
        }

        $query = 'SELECT salt, password, username, profile_picture, name FROM user WHERE email=?';
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $email,  PDO::PARAM_STR);

        if($stmt->execute()){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            //check if results returned anything
            if ($results !== false) {
                // $results contains data, proceed with accessing its elements
                $dbPassword = $results['password'];
                $salt_and_password = $this->password . $results['salt'];
                $hashedPassword = hash('sha256', $salt_and_password);

                if($dbPassword==$hashedPassword){
                    $this->username = $results['username'];
                    $this->profilePic = $results['profile_picture'];
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
            http_response_code(401);
            $msg = "User is already logged in.";

            return createJSONResponse('error', $msg);
        } else{
            $status="";
            $data="";

            //send to validRequest
            $credentialsValid = $this->validCredentials();
            //if validRequest is true

            if($credentialsValid['status']==true){
                $_SESSION["loggedIn"] = true;
                $_SESSION['username'] = $this->username;
                session_regenerate_id(true);
                $status = "success";
                $data = [
                    "username" => $this->username,
                    "profile_picture" => (int) $this->profilePic
                ];
                http_response_code(200);
            }
            else{
                $_SESSION["loggedIn"] = false;
                if (session_status() === PHP_SESSION_ACTIVE) {
                    session_destroy();
                }
                $status = "error";
                $data = $credentialsValid['data'];
                http_response_code(400);
            }
        }

        return createJSONResponse($status, $data);
    }
}

class Logout{

    // public $response_code;

    public function handleLogout(){
        if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true){
            $_SESSION['loggedIn']= false; //wait
            session_unset();
            session_destroy();
            http_response_code(200);
            return createJSONResponse("success", "Logout successful.");

        } else {
            http_response_code(401);
            return createJSONResponse("error", "User is not logged in.");
        }

    }
}

class AddReview{  //restricted to a user who is logged in
    private $connection;
    private $starRating;
    private $comment;
    private $mediaID;
    private $username;

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

        $this->starRating = filter_var($data['starRating'] ?? '', FILTER_VALIDATE_FLOAT);
        $this->mediaID = filter_var($data['mediaID'] ?? '', FILTER_VALIDATE_INT);
        $this->comment = htmlspecialchars($data['comment'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');

        if((!$this->starRating && !$this->comment) || !$this->mediaID){
            http_response_code(400);
            return createJSONResponse("error", "Missing parameters.");
        }

        $this->username = $_SESSION['username'];

        try {
            $query = 'INSERT INTO content_review (comments, starRating, mediaID) VALUES (?, ?, ?)';
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $this->comment,  PDO::PARAM_STR);
            $stmt->bindParam(2, $this->starRating, PDO::PARAM_INT);
            $stmt->bindParam(3, $this->mediaID, PDO::PARAM_INT);

            $stmt->execute();

            try {
                //get review ID FROM CONTENT REIVEW
                $insert_id = $this->connection->lastInsertId();

                $query = 'INSERT INTO writes (reviewID, username) VALUES (?, ?)';
                $stmt = $this->connection->prepare($query);
                $stmt->bindParam(1, $insert_id,  PDO::PARAM_INT);
                $stmt->bindParam(2, $this->username, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {

                //delete the insert into content_review
                $query2 = 'DELETE FROM content_review WHERE reviewID = ?';
                $stmt2 = $this->connection->prepare($query2);
                $stmt2->bindParam(1, $insert_id,  PDO::PARAM_INT);
                $stmt2->execute();
                unset($stmt);

                //Bob commented out $stmt->error
                return createJSONResponse("error", /*$stmt->error*/ $e->getMessage());
            }
        } catch (PDOException $e) {
            unset($stmt);
            http_response_code(500);
            return createJSONResponse("error", "MediaID, {$this->mediaID}, does not exist.");
        }

        http_response_code(200);
        $response = [
            "reviewID" => (int) $insert_id,
            "starRating" => (float) $this->starRating,
            "comment" => $this->comment,
            "media" =>$this->mediaID
        ];
        return createJSONResponse("success", $response);
    }
}

class GetReviews{  //no restrictoins
    /* username
    mediaID*/
    private $connection;
    private $username;

    public function __construct($db){
        $this->connection = $db;
    }

    public function handleGetReviews($data){

        if((!isset($data['username']) || $data['username']==null) && (!isset($data['mediaID']) || $data['mediaID']==null)){
            //error
            http_response_code(400);
            return createJSONResponse("error", "Missing parameters.");
        }

        if(isset($data['username'])){
            $limit= $data['limit'] ?? 20;  //default

            $query = 'SELECT writes.reviewID as reviewID, title, mediaID, starRating, comments, user.profile_picture as profile_picture FROM writes
            INNER JOIN user ON writes.username = user.username
            INNER JOIN content_review on writes.reviewID = content_review.reviewID
            INNER JOIN entertainment_content on content_review.mediaID = entertainment_content.media_ID
            WHERE user.username = ? LIMIT ?';


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
                        'username' => $data['username'],
                        'profile_picture' => (int) $row['profile_picture'],
                        'title' => $row['title'],
                        'mediaID' => (int) $row['mediaID'],
                        'reviewID' => (int) $row['reviewID'],
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

            $mediaID = $data['mediaID'];
            $limit= $data['limit'] ?? 20;  //default

            $query = 'SELECT writes.reviewID as reviewID, mediaID,title, writes.username as username, starRating, comments, user.profile_picture as profile_picture FROM writes
            INNER JOIN user on writes.username = user.username
            INNER JOIN content_review cr on writes.reviewID = cr.reviewID
            INNER JOIN entertainment_content ec on cr.mediaID = ec.media_ID
            WHERE mediaID = ?
            LIMIT ?';

            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $mediaID,  PDO::PARAM_STR);
            $stmt->bindParam(2, $limit,  PDO::PARAM_INT);

            try {
                //code...
                if($stmt->execute()){
                    $resultArr = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if(count($resultArr)==0){
                        unset($stmt);
                        return createJSONResponse("error", "No reviews for media with the ID = {$mediaID}.");
                    }

                    foreach($resultArr as $row){
                        $response[] = [
                            'username' => $row['username'],
                            'profile_picture' => (int) $row['profile_picture'],
                            'title' => $row['title'],
                            'mediaID' => (int) $row['mediaID'],
                            'reviewID' => (int) $row['reviewID'],
                            'starRating' => (float) $row['starRating'],
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

            } catch (PDOException $e) {
                unset($stmt);
                http_response_code(500);
                return createJSONResponse("error", $e->getMessage());
            }


        }
    }
}

class DeleteReview{ //restricted to a user who is logged in //post
    private $connection;
    // private $username;
    //username
    //reviewID

    public function __construct($db){
        $this->connection = $db;
    }

    public function handleDeleteReview($data){
        if (!isset($_SESSION['loggedIn'])) {
            http_response_code(401);
            return createJSONResponse("error", "User is not logged in.");
        }

        if(!isset($data['reviewID'])){
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
                    return createJSONResponse("success", "Review was successfully deleted.");
                } else {
                    unset($stmt1);
                    unset($stmt2);
                    http_response_code(500);
                    return createJSONResponse("error", $this->connection->error); //review id ne in content_review??
                }
            } else {
                unset($stmt1);
                unset($stmt2);
                http_response_code(500);
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

    public function __construct($db){
        $this->connection = $db;
    }

    public function handleGetFriends($username){
        if(!isset($username) || $username==null){
            http_response_code(400);
            return createJSONResponse("error", "Missing username.");
        }

        try {
            $query = 'SELECT friendID, user.profile_picture as profile_picture FROM friend 
                    INNER JOIN user ON friend.username = user.username 
                    WHERE user.username=?';
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $username,  PDO::PARAM_STR);

            if($stmt->execute()){
                $resultArr = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $response = [];
                foreach($resultArr as $row){
                    $response[] = [
                        'friendID' => $row['friendID'],
                        'profile_picture' => (int) $row['profile_picture']
                    ];
                }
                unset($stmt);

                http_response_code(200);
                return createJSONResponse("success", $response);
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

class AddFriend{ //post //user input
    /* usernameOrigin
    usernameFriend
    */

    private $connection;
    private $username;

    public function __construct($db){
        $this->connection = $db;
    }

    public function handleAddFriend($data){
        if(!isset($_SESSION['loggedIn'])){
            http_response_code(401);
            return createJSONResponse("error", "User is not logged in.");
        }

        if(!isset($data['friendID'])){
            http_response_code(400);
            return createJSONResponse("error", "Missing parameter.");
        }

        try {
            $this->username = $_SESSION['username'];
            $query = 'INSERT INTO friend (username, friendID) VALUES (?, ?)';
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $this->username,  PDO::PARAM_STR);
            $stmt->bindParam(2, $data['friendID'], PDO::PARAM_STR);

            if($stmt->execute()){
                unset($stmt);
                http_response_code(200);
                return createJSONResponse("success", "Friend added successfully.");
            }
            // else{ //could be unreachable
            //     unset($stmt);
            //     http_response_code(400);
            //     return createJSONResponse("error", $this->connection->error); //verify
            // }
        } catch(PDOException $e){
            // unset($stmt);
            http_response_code(500);
            return createJSONResponse("error", $e->getMessage());
        }
    }
}

class RemoveFriend{ //post
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
        if(!isset($_SESSION['username'])){
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
            // else{
            //     unset($stmt);
            //     http_response_code(500);
            //     return createJSONResponse("error", $this->connection->error);
            // }
        } catch (PDOException $e) {
            unset($stmt);
            http_response_code(500);
            return createJSONResponse("error", $e->getMessage());
        }
    }
}

class GetUsers{ //change to get
    private $connection;

    public function __construct($db){
        $this->connection = $db;
    }

    public function handleGetUsers($data){
        if(isset($data['username']) && $data['username']!=null){
            return $this->getUser($data['username']);
        }

        $limit = isset($data['limit']) ? (int)$data['limit'] : 20;
        $order = isset($data['order']) ? strtoupper($data['order']) : "ASC";

        if(!in_array($order, ["ASC", "DESC"])){
            $order = "ASC";
        }

        $query = "SELECT name, email, username, age, profile_picture, created_at FROM user ORDER BY name $order LIMIT :limit";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        if($stmt->execute()){
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($users);
            // unset($stmt);

            $response = [];
            foreach($users as $user){
                $response[] = [
                    'name' => $user['username'],
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'age' => (int) $user['age'],
                    'profile_picture' => (int) $user['profile_picture'],
                    'created_at' => $user['created_at']
                ];
            }

            http_response_code(200);
            return createJSONResponse("success", $response);
        } else {
            http_response_code(400);
            return createJSONResponse("error", "Failed to retrieve users.");
        }

    }

    public function getUser($username){
        $query = "SELECT name, email, username, age, profile_picture, created_at FROM user WHERE username=?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);

        if($stmt->execute()){
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user==false){
                unset($stmt);
                http_response_code(400);
                return createJSONResponse("error", "User, {$username}, does not exist.");
            }
            unset($stmt);


            $user['age'] = (int) $user['age'];
            $user['profile_picture'] = (int) $user['profile_picture'];

            http_response_code(200);
            return createJSONResponse("success", [$user]);
        } else {
            http_response_code(400);
            return createJSONResponse("error", "Failed to retrieve user.");
        }
    }

}

class ChangeProfilePicture{
    private $connection;

    public function __construct($db){
        $this->connection = $db;
    }

    public function changeProfile($data){
        $query = "UPDATE user SET profile_picture = ? WHERE username = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $data['profile_picture'], PDO::PARAM_INT);
        $stmt->bindParam(2, $_SESSION['username'], PDO::PARAM_STR);

        try {
            $stmt->execute();
            unset($stmt);
            http_response_code(200);
            return createJSONResponse("success", $data['profile_picture']);
        } catch (PDOException $e) {
            unset($stmt);
            http_response_code(500);
            return createJSONResponse("error", $e->getMessage());
        }
    }
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
    public $image_url;
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


        $query = "INSERT INTO entertainment_content (title, release_Date, description, content_rating, rating, poster_Url)  
                    VALUES (:title, :release_date, :description, :content_rating, :rating, :image_url);";

        $stmt = $this->connection->prepare($query);
        $this->title = filter_var($this->title, FILTER_SANITIZE_STRING);
        $this->release_date = filter_var($this->release_date, FILTER_VALIDATE_INT);
        $this->description = filter_var($this->description, FILTER_SANITIZE_STRING);
        $this->content_rating = filter_var($this->content_rating, FILTER_SANITIZE_STRING);
        $this->rating = filter_var($this->rating, FILTER_SANITIZE_NUMBER_INT);
        $this->image_url = filter_var($this->image_url, FILTER_SANITIZE_URL);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->release_date = intval(htmlspecialchars(strip_tags($this->release_date)));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->content_rating = htmlspecialchars(strip_tags($this->content_rating));
        $this->rating = intval(htmlspecialchars(strip_tags($this->rating)));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));


        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":release_date", $this->release_date);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":content_rating", $this->content_rating);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":image_url", $this->image_url);

        try {
            $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        } catch (PDOException $e) {
            return false;
        }

        $media_id = $this->connection->lastInsertId();

        if($this->type == "movie")
        {
            $query = "INSERT INTO movie (media_ID, duration) VALUES (:media_id, :duration);";
            $stmt = $this->connection->prepare($query);
            $this->duration = filter_var($this->duration, FILTER_SANITIZE_NUMBER_INT);
            $this->duration = intval(htmlspecialchars(strip_tags($this->duration)));
            $stmt->bindParam(":media_id", $media_id);
            $stmt->bindParam(":duration", $this->duration);
            try {
                $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
            }
            catch (PDOException $e)
            {
                return false;
            }
        }
        else if($this->type == "tvshow")
        {
            $query = "INSERT INTO tvshow (media_ID, seasons) VALUES (:media_id, :seasons);";
            $stmt = $this->connection->prepare($query);
            $this->seasons = filter_var($this->seasons, FILTER_SANITIZE_NUMBER_INT);
            $this->seasons = intval(htmlspecialchars(strip_tags($this->seasons)));
            $stmt->bindParam(":media_id", $media_id);
            $stmt->bindParam(":seasons", $this->seasons);
            try {
                $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
            }
            catch (PDOException $e)
            {
                return false;
            }
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
                try {
                    $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
                }
                catch (PDOException $e)
                {
                    return false;
                }
                $crew_id = $this->connection->lastInsertId();

                $query2 = "INSERT INTO involved_in (crewID, media_ID) VALUES (:crewID,:media_ID);";
                $stmt2 = $this->connection->prepare($query2);
                $stmt2->bindParam(":crewID", $crew_id);
                $stmt2->bindParam(":media_ID", $media_id);
                try {
                    $stmt2->execute() or die("Error: " . $stmt2->errorInfo()[2]);
                }
                catch (PDOException $e)
                {
                    return false;
                }
            }
        if($this->writers!=null)
            foreach($this->writers as $writer_name)
            {
                $writer_name = filter_var($writer_name, FILTER_SANITIZE_STRING);
                $writer_name = htmlspecialchars(strip_tags($writer_name));
                $stmt->bindParam(":name", $writer_name);
                $stmt->bindParam(":role", $writer);
                try {
                    $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
                }
                catch (PDOException $e)
                {
                    return false;
                }
                $crew_id = $this->connection->lastInsertId();

                $query2 = "INSERT INTO involved_in (crewID, media_ID) VALUES (:crewID,:media_ID);";
                $stmt2 = $this->connection->prepare($query2);
                $stmt2->bindParam(":crewID", $crew_id);
                $stmt2->bindParam(":media_ID", $media_id);
                try {
                    $stmt2->execute() or die("Error: " . $stmt2->errorInfo()[2]);
                }
                catch (PDOException $e)
                {
                    return false;
                }
            }
        if($this->directors!=null)
            foreach($this->directors as $director_name)
            {
                $director_name = filter_var($director_name, FILTER_SANITIZE_STRING);
                $director_name = htmlspecialchars(strip_tags($director_name));
                $stmt->bindParam(":name", $director_name);
                $stmt->bindParam(":role", $director);
                try {
                    $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
                }
                catch (PDOException $e)
                {
                    return false;
                }
                $crew_id = $this->connection->lastInsertId();

                $query2 = "INSERT INTO involved_in (crewID, media_ID) VALUES (:crewID,:media_ID);";
                $stmt2 = $this->connection->prepare($query2);
                $stmt2->bindParam(":crewID", $crew_id);
                $stmt2->bindParam(":media_ID", $media_id);
                try {
                    $stmt2->execute() or die("Error: " . $stmt2->errorInfo()[2]);
                }
                catch (PDOException $e)
                {
                    return false;
                }
            }

        if($this->genre!=null) {
            foreach ($this->genre as $genre) {
                $query = "SELECT genreID FROM genre WHERE genreName = :genre;";
                $stmt = $this->connection->prepare($query);
                $stmt->bindParam(":genre", $genre);
                try {
                    $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
                }catch(PDOException $e)
                {
                    return false;
                }

                if($stmt->rowCount() > 0) {
                    $r = $stmt->fetch(PDO::FETCH_ASSOC);
                    $genre_id = $r["genreID"];
                    $query2 = "INSERT INTO belongs (genreID, media_ID) VALUES (:genreID, :media_ID);";
                    $stmt2 = $this->connection->prepare($query2);
                    $stmt2->bindParam(":genreID", $genre_id);
                    $stmt2->bindParam(":media_ID", $media_id);
                    try
                    {
                        $stmt2->execute() or die("Error: " . $stmt2->errorInfo()[2]);

                    }catch (PDOException $e)
                    {
                        return false;
                    }
                }
                else
                    return false;
            }
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
        $this->media_id = filter_var($this->media_id, FILTER_SANITIZE_NUMBER_INT);
        $this->media_id = intval(htmlspecialchars(strip_tags($this->media_id)));
        $stmt->bindParam(":media_id", $this->media_id);
        try {
            $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        }catch (PDOException $e)
        {
            return false;
        }
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
        try {
            $check = $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        }catch (PDOException $e)
        {
            return false;
        }
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
        try {
            $check = $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        }catch (PDOException $e)
        {
            return false;
        }
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
        try {
            $check = $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        }
        catch (PDOException $e)
        {
            return false;
        }
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
        $this->media_id = filter_var($this->media_id, FILTER_SANITIZE_NUMBER_INT);
        $this->media_id = intval(htmlspecialchars(strip_tags($this->media_id)));
        $this->username = filter_var($this->username, FILTER_SANITIZE_STRING);
        $this->username = htmlspecialchars(strip_tags($this->username));

        $stmt->bindParam(":media_id", $this->media_id);
        $stmt->bindParam(":username", $this->username);
        try {
            $check = $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        }catch (PDOException $e)
        {
            return false;
        }
        return $check;
    }

    public function addWishlistWithoutMediaID()
    {
        $query = "SELECT media_ID FROM entertainment_content WHERE title = :title;";
        $stmt = $this->connection->prepare($query);
        $this->title = filter_var($this->title, FILTER_SANITIZE_STRING);
        $this->title = htmlspecialchars(strip_tags($this->title));
        $stmt->bindParam(":title", $this->title);
        try {
            $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        }catch (PDOException $e)
        {
            return false;
        }
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if(isset($r["media_ID"]))
            $this->media_id = $r["media_ID"];
        else
            return false;

//        echo($this->media_id . " " . $this->username);
        $query = "INSERT INTO wants_to_watch (username, mediaID) VALUES (:username,:media_id);";
        $stmt = $this->connection->prepare($query);
        $this->media_id = filter_var($this->media_id, FILTER_SANITIZE_NUMBER_INT);
        $this->media_id = intval(htmlspecialchars(strip_tags($this->media_id)));
        $this->username = filter_var($this->username, FILTER_SANITIZE_STRING);
        $this->username = htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":media_id", $this->media_id);
        try {
            $check = $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        } catch (PDOException $e) {
            return false;
        }
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
    public $minRating;
    public $maxRating;
    public $minReleaseDate;
    public $maxReleaseDate;
    public $minDuration;
    public $maxDuration;
    public $minSeasons;
    public $maxSeasons;

    public $search_media_id, $search_title, $search_genre, $search_rating, $search_content_rating, $search_release_date, $search_type, $search_cast, $search_director, $search_writer;


    public function __construct($db)
    {
        $this->connection = $db;

        $this->return = $this->search = $this->limit = $this->sort = $this->order = $this->search_media_id = $this->search_title = $this->search_genre = $this->search_rating = $this->search_content_rating = $this->search_release_date = $this->search_type = $this->search_cast = $this->search_director = $this->search_writer = $this->minRating = $this->maxRating = $this->minReleaseDate = $this->maxReleaseDate = $this->minDuration = $this->maxDuration = $this->minSeasons = $this->maxSeasons = null;
    }





    public function Return_Parameters()
    {
        $v1 = "SELECT list.media_ID, title, release_Date, description, content_rating, rating, poster_Url, Genre, CAST, DIRECTOR, WRITER, duration, seasons FROM (
    SELECT e.media_ID, title, release_Date, description, content_rating, rating, poster_Url,
           GROUP_CONCAT(DISTINCT g.genreName) AS Genre,
           GROUP_CONCAT(DISTINCT CASE WHEN c.role = 'actor' THEN c.name END) AS CAST,
           GROUP_CONCAT(DISTINCT CASE WHEN c.role = 'director' THEN c.name END) AS DIRECTOR,
           GROUP_CONCAT(DISTINCT CASE WHEN c.role = 'writer' THEN c.name END) AS WRITER
    FROM belongs AS b
    INNER JOIN entertainment_content AS e ON e.media_ID = b.media_ID
    LEFT JOIN genre AS g ON g.genreID = b.genreID
    INNER JOIN involved_in i on e.media_ID = i.media_ID
    LEFT JOIN crew c on i.crewID = c.crewID
    GROUP BY e.media_ID, i.media_ID
) AS list
LEFT JOIN movie ON list.media_ID = movie.media_ID
LEFT JOIN tvshow ON list.media_ID = tvshow.media_ID";

        if($this->return === "*")
        {
            $this->query = $v1;
        }
        else
        {
            $this->query .= "SELECT ";
            $this->query .= join(", ", $this->return);
            $this->query .= " FROM (
    SELECT e.media_ID, title, release_Date, description, content_rating, rating, poster_Url,
           GROUP_CONCAT(DISTINCT g.genreName) AS Genre,
           GROUP_CONCAT(DISTINCT CASE WHEN c.role = 'actor' THEN c.name END) AS CAST,
           GROUP_CONCAT(DISTINCT CASE WHEN c.role = 'director' THEN c.name END) AS DIRECTOR,
           GROUP_CONCAT(DISTINCT CASE WHEN c.role = 'writer' THEN c.name END) AS WRITER
    FROM belongs AS b
    INNER JOIN entertainment_content AS e ON e.media_ID = b.media_ID
    LEFT JOIN genre AS g ON g.genreID = b.genreID
    INNER JOIN involved_in i on e.media_ID = i.media_ID
    LEFT JOIN crew c on i.crewID = c.crewID
    GROUP BY e.media_ID, i.media_ID
) AS list
LEFT JOIN movie ON list.media_ID = movie.media_ID
LEFT JOIN tvshow ON list.media_ID = tvshow.media_ID ";
        }
    }





    public function executeQuery()
    {
//        echo($this->query);
        $stmt = $this->connection->prepare($this->query);

        $this->limit = filter_var($this->limit, FILTER_SANITIZE_NUMBER_INT);
        $this->limit = intval(htmlspecialchars(strip_tags($this->limit)));
        $this->search = filter_var($this->search, FILTER_SANITIZE_STRING);
        $this->search = htmlspecialchars(strip_tags($this->search));
        $this->search_title = filter_var($this->search_title, FILTER_SANITIZE_STRING);
        $this->search_title = htmlspecialchars(strip_tags($this->search_title));
        $this->search_genre = filter_var($this->search_genre, FILTER_SANITIZE_STRING);
        $this->search_genre = htmlspecialchars(strip_tags($this->search_genre));
        $this->search_rating = filter_var($this->search_rating, FILTER_SANITIZE_NUMBER_INT);
        $this->search_rating = intval(htmlspecialchars(strip_tags($this->search_rating)));
        $this->search_content_rating = filter_var($this->search_content_rating, FILTER_SANITIZE_STRING);
        $this->search_content_rating = htmlspecialchars(strip_tags($this->search_content_rating));
        $this->search_release_date = filter_var($this->search_release_date, FILTER_SANITIZE_NUMBER_INT);
        $this->search_release_date = intval(htmlspecialchars(strip_tags($this->search_release_date)));
        $this->search_type = filter_var($this->search_type, FILTER_SANITIZE_STRING);
        $this->search_type = htmlspecialchars(strip_tags($this->search_type));
        $this->search_cast = filter_var($this->search_cast, FILTER_SANITIZE_STRING);
        $this->search_cast = htmlspecialchars(strip_tags($this->search_cast));
        $this->search_director = filter_var($this->search_director, FILTER_SANITIZE_STRING);
        $this->search_director = htmlspecialchars(strip_tags($this->search_director));
        $this->search_writer = filter_var($this->search_writer, FILTER_SANITIZE_STRING);
        $this->search_writer = htmlspecialchars(strip_tags($this->search_writer));
        $this->search_media_id = filter_var($this->search_media_id, FILTER_SANITIZE_NUMBER_INT);
        $this->search_media_id = intval(htmlspecialchars(strip_tags($this->search_media_id)));
        $this->minRating = filter_var($this->minRating, FILTER_SANITIZE_NUMBER_INT);
        $this->minRating = intval(htmlspecialchars(strip_tags($this->minRating)));
        $this->maxRating = filter_var($this->maxRating, FILTER_SANITIZE_NUMBER_INT);
        $this->maxRating = intval(htmlspecialchars(strip_tags($this->maxRating)));
        $this->minReleaseDate = filter_var($this->minReleaseDate, FILTER_SANITIZE_NUMBER_INT);
        $this->minReleaseDate = intval(htmlspecialchars(strip_tags($this->minReleaseDate)));
        $this->maxReleaseDate = filter_var($this->maxReleaseDate, FILTER_SANITIZE_NUMBER_INT);
        $this->maxReleaseDate = intval(htmlspecialchars(strip_tags($this->maxReleaseDate)));
        $this->minDuration = filter_var($this->minDuration, FILTER_SANITIZE_NUMBER_INT);
        $this->minDuration = intval(htmlspecialchars(strip_tags($this->minDuration)));
        $this->maxDuration = filter_var($this->maxDuration, FILTER_SANITIZE_NUMBER_INT);


        if($this->limit != null)
            $stmt->bindValue(":limit", $this->limit, PDO::PARAM_INT);
        if($this->search_title != null)
            $stmt->bindValue(":search_title", $this->search_title, PDO::PARAM_STR);
        if($this->search_genre != null)
            $stmt->bindValue(":search_genre", $this->search_genre, PDO::PARAM_STR);
        if($this->search_rating != null)
            $stmt->bindValue(":search_rating", $this->search_rating, PDO::PARAM_INT);
        if($this->search_content_rating != null)
            $stmt->bindValue(":search_content_rating", $this->search_content_rating, PDO::PARAM_STR);
        if($this->search_release_date != null)
            $stmt->bindValue(":search_release_date", $this->search_release_date, PDO::PARAM_INT);
        if($this->search_cast != null)
            $stmt->bindValue(":search_cast", $this->search_cast, PDO::PARAM_STR);
        if($this->search_director != null)
            $stmt->bindValue(":search_director", $this->search_director, PDO::PARAM_STR);
        if($this->search_writer != null)
            $stmt->bindValue(":search_writer", $this->search_writer, PDO::PARAM_STR);
        if($this->search_media_id != null)
            $stmt->bindValue(":search_media_id", $this->search_media_id, PDO::PARAM_INT);
        if($this->minRating != null)
            $stmt->bindValue(":minRating", $this->minRating, PDO::PARAM_INT);
        if($this->maxRating != null)
            $stmt->bindValue(":maxRating", $this->maxRating, PDO::PARAM_INT);
        if($this->minReleaseDate != null)
            $stmt->bindValue(":minReleaseDate", $this->minReleaseDate, PDO::PARAM_INT);
        if($this->maxReleaseDate != null)
            $stmt->bindValue(":maxReleaseDate", $this->maxReleaseDate, PDO::PARAM_INT);
        if($this->minDuration != null)
            $stmt->bindValue(":minDuration", $this->minDuration, PDO::PARAM_INT);
        if($this->maxDuration != null)
            $stmt->bindValue(":maxDuration", $this->maxDuration, PDO::PARAM_INT);
        if($this->minSeasons != null)
            $stmt->bindValue(":minSeasons", $this->minSeasons, PDO::PARAM_INT);
        if($this->maxSeasons != null)
            $stmt->bindValue(":maxSeasons", $this->maxSeasons, PDO::PARAM_INT);



        try {
            $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        }
        catch (PDOException $e)
        {
//            echo("Error: " . $e->getMessage());
            return false;
        }
        return $stmt;
    }

    public function Where()
    {
        $this->query .= " WHERE ";
    }

    public function MinRating()
    {
        $this->query .= " rating >= :minRating ";
    }

    public function MaxRating()
    {
        $this->query .= " rating <= :maxRating ";
    }

    public function MinReleaseDate()
    {
        $this->query .= " release_date >= :minReleaseDate ";
    }

    public function MaxReleaseDate()
    {
        $this->query .= " release_date <= :maxReleaseDate ";
    }

    public function MinDuration()
    {
        $this->query .= " duration >= :minDuration ";
    }

    public function MaxDuration()
    {
        $this->query .= " duration <= :maxDuration ";
    }

    public function MinSeasons()
    {
        $this->query .= " seasons >= :minSeasons ";
    }

    public function MaxSeasons()
    {
        $this->query .= " seasons <= :maxSeasons ";
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
        $this->query .= " Genre LIKE :search_genre ";
    }

    public function Search_cast()
    {
        $this->query .= " CAST LIKE :search_cast ";
    }

    public function Search_media_id()
    {
        $this->query .= " media_ID = :search_media_id ";
    }

    public function Search_director()
    {
        $this->query .= " DIRECTOR LIKE :search_director ";
    }

    public function Search_writer()
    {
        $this->query .= " WRITER = :search_writer ";
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
        if($this->search_type == "movie")
            $this->query .= " seasons IS NULL ";
        else if($this->search_type == "tvshow")
            $this->query .= " duration IS NULL ";
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
        $this->sort = filter_var($this->sort, FILTER_SANITIZE_STRING);
        $this->sort = htmlspecialchars(strip_tags($this->sort));
        $this->order = filter_var($this->order, FILTER_SANITIZE_STRING);
        $this->order = htmlspecialchars(strip_tags($this->order));
        $this->query .= " ORDER BY " . $this->sort ." " . $this->order ." ";
    }


    public function closeQuery()
    {
        $this->query .= ";";
    }

}



class getWishlist
{
    private $connection;
    public $username;
    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function getWishlist()
    {
        $query = "SELECT media_ID title, release_Date, description, content_rating, rating, poster_Url FROM wants_to_watch
                    INNER JOIN entertainment_content ON wants_to_watch.mediaID = entertainment_content.media_ID
                    WHERE username = :username;";
        $stmt = $this->connection->prepare($query);
        $this->username = filter_var($this->username, FILTER_SANITIZE_STRING);
        $this->username = htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(":username", $this->username);
        try {
            $check = $stmt->execute() or die("Error: " . $stmt->errorInfo()[2]);
        }catch (PDOException $e)
        {
            return false;
        }
        if($check)
            return $stmt;
        else
            return false;
    }
}