<?php

require_once 'dbconnect.php';
require_once 'login.php';

//Takes resposne info and adds it into the Responses database table
//T/F and MC responses are submitted as response ID numbers, while
//short answer is submitted as a string
function submitResponse($surveyid, $questionid, $response)
{
	$dbhandle = db_connect();
	session_start();
	
	$userid = getUserID();
	
	//error - login failure
	if ($userid == -1)
		return -1;
	
	//security
	$surveyid = mysql_real_escape_string($surveyid);
	$questionid = mysql_real_escape_string($questionid);
	$response = mysql_real_escape_string($response);
	
	//make sure survey and question exists
	if (!checkForQuestion($surveyid, $questionid))
	{
		db_close($dbhandle);
		return -301;
	}
	
	//TODO - some check for if user submitted this question already
	//We might bar it or simply overwrite the old response
	
	//all is well, add it to DB
	$query = "INSERT INTO Responses(SurveyID, QuestionID, Response, UserID) VALUES ({$surveyid}, {$questionid}, {$response}, {$userid})";
	$result = mysql_query($query);
	
	//close db and return
	db_close($dbhandle);
	
	return 0;
}

//check if question actually exists
checkForQuestion($surveyid, $questionid)
{
	$query = "SELECT * FROM Surveys WHERE SurveyID={$surveyid} AND QuestionID={$questionid}";
	$result = mysql_query($query);
	
	if(mysql_num_rows($result) == 0) //question doesn't exist
		return 0;
	
	//if we made it here, it exists
	return 1;
}

?>
