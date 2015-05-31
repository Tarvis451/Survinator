<?php
$sqlname = "root";
$sqlpass = "datapass";
//should be localhost?
//$hostname = "travis-webserver.dyndns.org"; 
$hostname = "localhost"; 

//input from registration form
$user = $_POST['Username'];
$pass = $_POST['Password'];


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
$sqlquery = "SELECT Username FROM Users where Username='{$user}'";
echo($sqlquery);
$result = mysql_query($sqlquery);

if(mysql_num_rows($result) == 0)
{
  echo("User not found");
}


//make new user

//close the connection
mysql_close($dbhandle);
?>
