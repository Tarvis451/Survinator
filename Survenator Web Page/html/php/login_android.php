<?php
    require 'dbconnect.php';
    $dbhandle = db_connect();
    $user = mysql_real_escape_string($_POST['username']);
    $pass = mysql_real_escape_string($_POST['password']);
    
    //query user
    $sqlquery = "SELECT UserName FROM Users where UserName='{$user}'";
    $result = mysql_query($sqlquery);
    
    //fail if user already exists
    if(mysql_num_rows($result) == 0)
    {
	    mysql_close($dbhandle);
	    $response["error"] = 91;
	    $response["message"] = "Specified user does not exist";
            echo json_encode($response);
	    die();
    }
    
    //query password
    //TODO - use hashed password instead of plaintext
    $sqlquery = "SELECT UserID FROM Users WHERE UserName='{$user}' AND HashPassword='{$pass}' LIMIT 1";
    $result = mysql_query($sqlquery);
    
    //fail if wrong password
    if(mysql_num_rows($result) == 0)
    {
	    mysql_close($dbhandle);
	    $response["error"] = 92;
            $response["message"] = "Incorrect password";
            echo json_encode($response);
	    die();
    }
    
    $row = mysqli_fetch_array($result);
    
    //create login session
    session_start();
    $_SESSION["userid"] = $row['UserID'];
    $_SESSION["user"] = $user;
    
    db_close($dbhandle);
    
    //redirect to main page
    //header("Location: /MainOptions.html");
    $response["error"] = 0;
    $response["message"] = "Logged in";
    $response["userid"] = $_SESSION["userid"];
    echo json_encode($response);
    die();
    
?>
