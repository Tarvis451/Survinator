<?php
//Havn't done anything to this file yet - Sam



$sqlname = "root";
$sqlpass = "datapass";
$hostname = "localhost"; 

//input from registration form
$user = $_POST['username'];
$pass = $_POST['password'];

//connection to the database
$dbhandle = mysql_connect($hostname, $sqlname, $sqlpass) 
	or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db("Survinator",$dbhandle) 
	or die("Could not select Survinator");
	
//Query, Insert True/False question into
$sqlquery = "SELECT Username FROM Users where Username='{$user}'";
$result = mysql_query($sqlquery);

//make new user
//TODO - get hashed password instead of plaintext
$sqlquery = "INSERT INTO Users(Username, HashPassword) VALUES ('{$user}', '{$pass}')";
$result = mysql_query($sqlquery);

//redirect to registration success page
mysql_close($dbhandle);
header("location: /UserRegistrationSuccess.html");
die("You are registered!");

?>
