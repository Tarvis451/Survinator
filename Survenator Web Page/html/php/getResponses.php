<?php

require_once 'dbconnect.php';
require_once 'login.php';

//For MC and TF
function getResponseChoices($surveyid, $questionid, $numChoices)
{
	$dbhandle = db_connect();
	
	$surveyid = mysql_real_escape_string($surveyid);
	$questionid = mysql_real_escape_string($questionid);
	
	$responses = array();
	
	for ($response = 1; $response < $numChoices; $response++)
	{
		$query = "SELECT COUNT(*) AS Count FROM Responses WHERE SurveyID={$surveyid} AND QuestionID={$questionid} AND Response='{$response}'";
		$result = mysql_query($query);
		
		$row = mysql_fetch_array($result);
		array_push($responses, $row['Count']);
	}
	
	db_close($dbhande);
	
	return $responses;
}

//For FR
function getResponseList($surveyid, $questionid)
{
	$dbhandle = db_connect();
	
	$query = "SELECT Response FROM Responses WHERE SurveyID={$surveyid} AND QuestionID={$questionid}";
	$result = mysql_query($query);
	
	$responses = array();
	
	while ($row = mysql_fetch_array($result))
		array_push($responses, $row['Response']);
	
	db_close($dbhandle);
	
	return $responses;
}

?>