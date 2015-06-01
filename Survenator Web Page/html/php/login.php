<?php

    require 'dbconnect.php';
    $dbhandle = db_connect();

    $user = mysql_real_escape_string($_POST['username']);
    $pass = mysql_real_escape_string($_POST['password']);
    
    //query user
    $sqlquery = "SELECT Username FROM Users where Username='{$user}'";
    $result = mysql_query($sqlquery);
    
    //fail if user already exists
    if(mysql_num_rows($result) == 0)
    {
	    mysql_close($dbhandle);
	    die("Specified user does not exist<br>");
    }
    
    //query password
    //TODO - use hashed password instead of plaintext
    $sqlquery = "SELECT UserID FROM Users WHERE Username='{$user}' AND HashPassword='{$pass}' LIMIT 1";
    $result = mysql_query($sqlquery);
    
    //fail if wrong password
    if(mysql_num_rows($result) == 0)
    {
	    mysql_close($dbhandle);
	    die("Incorrect password<br>");
    }
    
    $row = mysqli_fetch_array($result);
    
    //create login session
    session_start();
    $_SESSION["userid"] = $row['UserID'];
    $_SESSION["user"] = $user;
    
    db_close($dbhandle);
    
    //redirect to main page
    header("Location: /MainOptions.html");
    die("Logged in<br>");
    
?>
