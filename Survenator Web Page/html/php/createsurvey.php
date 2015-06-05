<?php

require_once 'dbconnect.php';

function addSurvey($intitle, $indesc, $inpub)
{
	$dbhandle = db_connect();
	session_start();

	$title = mysql_real_escape_string($intitle);
	$desc = mysql_real_escape_string($indesc);
	
	//check if user is logged in
	if (!isset($_SESSION['userid']))
	{
		db_close($dbhandle);
		return -1;
	}
	
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
	$query = "INSERT INTO SurveyList(SurveyName, UserID, Published, SurveyDescription) VALUES ('{$title}','{$userid}',{$inpub},'{$desc}')";
	$result = mysql_query($query);

	//get survey id for retrn
	$query = "SELECT SurveyID FROM SurveyList WHERE SurveyName = '{$title}'";
	$result = mysql_query($query);

	$row = mysql_fetch_array($result);

	$surveyid = $row['SurveyID'];

	db_close($dbhandle);

	return($surveyid);	
}

function publishSurvey($insurveyid)
{
	$dbhandle = db_connect();
	
	$surveyid = mysql_real_escape_string($insurveyid);
	
	$query = "UPDATE SurveyList SET Published=1 WHERE SurveyID={$surveyid}";
	$result = mysql_query($query);
	
	db_close($dbhandle);
	
	return;
}

?>
