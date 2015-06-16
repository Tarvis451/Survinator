<?php

function login($inuser, $inpass)
{
	require 'dbconnect.php';
	$dbhandle = db_connect();
	
	$user = mysql_real_escape_string($inuser);
	$pass = mysql_real_escape_string($inpass);
	
	//query user
	$sqlquery = "SELECT UserID, HashPassword FROM Users WHERE UserName='{$user}'";
	$result = mysql_query($sqlquery);
	
	//fail if user does not exist
	if(mysql_num_rows($result) == 0)
	{
		mysql_close($dbhandle);
		return 91;
	}
	
	//query password
	$row = mysql_fetch_array($result);
	$hashpass = $row['HashPassword'];
	
	//check if using old unhashed pass
	if (password_needs_rehash($pass, PASSWORD_BCRYPT))
	{
		if ($pass == $hashpass) //rehash it if so
		{
			$hashpass = password_hash($pass, PASSWORD_BCRYPT);
			$query = "UPDATE Users SET HashPassword='{$hashpass}' WHERE UserName='{$user}'";
			$result = mysql_query($query);
		}
	}
	
	//fail if password does not match
	if (!password_verify($pass, $hashpass))
		return 92;

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

//Checks if a user is logged in
//1 - logged in
//0 - not logged in
function checklogin()
{
	session_start();
      
	if(empty($_SESSION['userid']))
	{
		return false;
	}
	return true;
}

function getUserID()
{
	session_start();
      
	if(empty($_SESSION['userid']))
		return -1;
	else
		return $_SESSION['userid'];
}
    
?>
