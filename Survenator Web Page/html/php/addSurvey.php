<?php

function addSurvey($intitle, $indesc)
{
	echo "Adding {$intitle} with {$indesc}";
	require 'login.php';
	require 'dbconnect.php';

	$dbhandle = db_connect();

	$title = mysql_real_escape_string($intitle);
	$desc = mysql_real_escape_string($indesc);
	$userid = $_SESSION['userid'];

	//check if name is valid
	if(strlen($title) < 3)
	{
		db_close($dbhandle);
		return -101;
	}

	//check if survey name is taken
	$query = "SELECT SurveyName FROM SurveyList WHERE SurveyName = '{$title}'";
	$result = mysql_query($query);

	if(mysql_num_rows($result) != 0)
	{
		db_close($dbhandle);
		return -102;
	}

	//info looks good, add to db
	$query = "INSERT INTO SurveyList(SurveyName, UserID, Published, SurveyDescription) VALUES ('{$title}','{$userid}',0,'{$desc}')";
	$result = mysql_query($query);

	//get survey id for retrn
	$query = "SELECT SurveyID FROM SurveyList WHERE SurveyName = '{$title}'";
	$result = mysql_query($query);

	$row = mysql_fetch_array($result);

	$surveyid = $row['SurveyID'];

	db_close($dbhandle);

	return($surveyid);	
}

?>
