<?php

$sqlname = "root";
$sqlpass = "datapass";
//should be localhost?
//$hostname = "travis-webserver.dyndns.org"; 
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

//execute the SQL query and return records
$result = mysql_query("SELECT * FROM Users");

//fetch tha data from the database 
while ($row = mysql_fetch_array($result)) {
	echo "UserID:".$row{'UserID'}."<br>UserName:".$row{'UserName'}."<br>HashPassword: ". //display the results
	$row{'HashPassword'}."<br>";
}

//check if user already exists
//FIXME - protect query from injection!!
$sqlquery = "SELECT Username FROM Users where Username='{$user}'";
$result = mysql_query($sqlquery);

//fail if user already exists
if(mysql_num_rows($result) != 0)
{
	mysql_close($dbhandle);
	die("User already exists!");
}

//make new user
$sqlquery = "INSERT INTO Users(Username, HashPassword) VALUES ('{$user}', '{$pass}')";
$result = mysql_query($sqlquery);
echo($result);

//redirect to login page, print confirm message
mysql_close($dbhandle);
die("You are registered!");

?>
