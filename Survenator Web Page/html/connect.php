<?php
$username = "root";
$password = "datapass";
//should be localhost?
//$hostname = "travis-webserver.dyndns.org"; 
$hostname = "localhost"; 


//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
 or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db("Survinator",$dbhandle) 
  or die("Could not select Survinator");

//execute the SQL query and return records
$result = mysql_query("SELECT * FROM Users");

//fetch tha data from the database 
while ($row = mysql_fetch_array($result)) {
   echo "UserID:".$row{'UserID'}." UserName:".$row{'UserName'}." HashPassword: ". //display the results
   $row{'HashPassword'}."<br>";
}
//close the connection
mysql_close($dbhandle);
?>
