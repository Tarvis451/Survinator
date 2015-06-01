<?php

require 'dbconnect.php';
$dbhandle = db_connect();

//input from registration form
$user = mysql_real_escape_string($_POST['username']);
$pass = mysql_real_escape_string($_POST['password']);
	
//validate username & password
//Current restrictions:
//username: no less than 3 chars
//password: no less than 3 chars
if ((strlen($user) < 3) || (strlen($pass) < 3))
{
	db_close($dbhandle);
	$response["error"] = 81;
        $response["message"] = "Username and password must be at least 3 characters long!";
	die(json_response);
}

//check if user already exists
$sqlquery = "SELECT UserName FROM Users where UserName='{$user}'";
$result = mysql_query($sqlquery);

//fail if user already exists
if(mysql_num_rows($result) != 0)
{
	db_close($dbhandle);
	$response["error"] = 82;
	$response["message"] = "User already exists!"
	die(json_encode($response));
}

//make new user
//TODO - get hashed password instead of plaintext
$sqlquery = "INSERT INTO Users(UserName, HashPassword) VALUES ('{$user}', '{$pass}')";
$result = mysql_query($sqlquery);

//redirect to registration success page
db_close($dbhandle);
//header("location: /UserRegistrationSuccess.html");
$response["error"]=0;
$response["message"]="You are registered!"
die(json_encode($response));

?>

