<?php

$sqlname = "root";
$sqlpass = "datapass";
$hostname = "localhost"; 

//input from registration form
$Name = $_POST['Name'];
$Description = $_POST['Description'];

//connection to the database
$dbhandle = mysql_connect($hostname, $sqlname, $sqlpass) 
	or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db("Survinator",$dbhandle) 
	or die("Could not select Survinator");

//UserID will be embedded in the url
$sqlquery = "INSERT INTO SurveyList(SurveyName, UserID, SurveyDescription) VALUES ('{Name}', '{UserID}', '{Description}')";
$result = mysql_query($sqlquery);

//fail if survey already exists
if(mysql_num_rows($result) != 0)
{
	mysql_close($dbhandle);
	die("Survey name has already been used!");
}

//Retrieve SurveyID, Retreive UserID in past page
$SurveyIDquery = "SELECT SurveyID FROM SurveyList where SurveyName = '{$Name}'";
$SurveyID = mysql_query($SurveyIDquery);

//redirect to registration success page
mysql_close($dbhandle);
header("location: /create.html?UserID={$UserID}&SurveyID={$SurveyID}");
die("Survey Creation Process Started!");

?>
