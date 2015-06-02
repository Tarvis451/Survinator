<?php

function login($inuser, $inpass)
{
    require 'dbconnect.php';
    $dbhandle = db_connect();
    
    $user = mysql_real_escape_string($inuser);
	$pass = mysql_real_escape_string($inpass);
    
    //query user
    $sqlquery = "SELECT UserName FROM Users where UserName='{$user}'";
    $result = mysql_query($sqlquery);
    
    //fail if user does not exist
    if(mysql_num_rows($result) == 0)
    {
	    mysql_close($dbhandle);
	    return 91;
    }
    
    //query password
    //TODO - use hashed password instead of plaintext
    $sqlquery = "SELECT UserID FROM Users WHERE UserName='{$user}' AND HashPassword='{$pass}'";
    $result = mysql_query($sqlquery); // This is guaranteed to return ONLY the UserID. That is, if a user logs in successfully,
    					// The entire result set will be {<value of UserID>} (assuming they are a valid user).
    
    //fail if wrong password
    if(mysql_num_rows($result) == 0)
    {
	    mysql_close($dbhandle);
	    return 92;
    }
    
    $row = mysql_fetch_array($result);

    //Grab the UserID for the redirect link
    $userid = $row['UserID'];

    //create login session
    session_start();
    $_SESSION["userid"] = $userid;
    $_SESSION["user"] = $user;
    
    db_close($dbhandle);

	//return 0 indicates succes
    return 0;
}
    
?>
