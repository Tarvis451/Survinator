<?php

function register_user($inuser, $inpass)
{
	require 'dbconnect.php';
	$dbhandle = db_connect();

	//input from registration form
	$user = mysql_real_escape_string($inuser);
	$pass = mysql_real_escape_string($inpass);
		
	//validate username & password
	//Current restrictions:
	//username: no less than 3 chars
	//password: no less than 3 chars
	if ((strlen($user) < 3) || (strlen($pass) < 3))
	{
		db_close($dbhandle);
		return 81;
	}
	
	//check if user already exists
	$sqlquery = "SELECT UserName FROM Users where UserName='{$user}'";
	$result = mysql_query($sqlquery);
	
	//fail if user already exists
	if(mysql_num_rows($result) != 0)
	{
		db_close($dbhandle);
		return 82;
	}
	
	//make new user
	//TODO - get hashed password instead of plaintext
	$sqlquery = "INSERT INTO Users(UserName, HashPassword) VALUES ('{$user}', '{$pass}')";
	$result = mysql_query($sqlquery);
	
	//redirect to registration success page
	db_close($dbhandle);
	return 0;
}

?>
