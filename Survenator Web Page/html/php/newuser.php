<?php

require 'dbconnect.php';
$dbhandle = db_connect();

//input from registration form
$user = mysql_real_escape_string($_POST['username']);
$pass = mysql_real_escape_string($_POST['password']);
	
//TODO - prevent invalid usernames (e.g. empty strings)

//check if user already exists
$sqlquery = "SELECT Username FROM Users where Username='{$user}'";
$result = mysql_query($sqlquery);

//fail if user already exists
if(mysql_num_rows($result) != 0)
{
	db_close($dbhandle);
	die("User already exists!");
}

//make new user
//TODO - get hashed password instead of plaintext
$sqlquery = "INSERT INTO Users(Username, HashPassword) VALUES ('{$user}', '{$pass}')";
$result = mysql_query($sqlquery);

//redirect to registration success page
db_close($dbhandle);
header("location: /UserRegistrationSuccess.html");
die("You are registered!");

?>
