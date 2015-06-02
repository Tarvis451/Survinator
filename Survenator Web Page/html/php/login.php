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
	    die("Specified user does not exist<br>");
    }
    
    //query password
    //TODO - use hashed password instead of plaintext
    $sqlquery = "SELECT UserID FROM Users WHERE UserName='{$user}' AND HashPassword='{$pass}' LIMIT 1";
    $result = mysql_query($sqlquery); // This is guaranteed to return ONLY the UserID. That is, if a user logs in successfully,
    					// The entire result set will be {<value of UserID>} (assuming they are a valid user).
    
    //fail if wrong password
    if(mysql_num_rows($result) == 0)
    {
	    mysql_close($dbhandle);
	    die("Incorrect password<br>");
    }
    
    $row = mysqli_fetch_array($result);

    //Grab the UserID for the redirect link
    $UserIDquery = "SELECT UserID FROM Users WHERE UserName='{$user}'";
    $UserID = mysql_query($UserIDquery);
    
    //create login session
    session_start();
    $_SESSION["userid"] = $row['UserID'];
    $_SESSION["user"] = $user;
    
    db_close($dbhandle);
    
    //redirect to main page, embedded UserID into redirect link
    header("Location: /MainOptions.html?UserID='{$UserID}'");
    die("Logged in<br>");
    
?>
