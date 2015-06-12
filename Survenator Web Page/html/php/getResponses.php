<?php

require_once 'dbconnect.php';
require_once 'login.php';

//For MC and TF
function getResponseChoices($surveyid, $questionid)
{
	$dbhandle = db_connect();
	
	$surveyid = mysql_real_escape_string($surveyid);
	$questionid = mysql_real_escape_string($questionid);
	
	//get number of choices
	$query = "SELECT * FROM Surveys WHERE SurveyID={$surveyid} AND QuestionID={$questionid}";
	$result = mysql_query($query);
	
	$numChoices = mysql_num_rows($result);
	
	//form the array of response counts
	$responses = array();
	
	for ($response = 1; $response <= $numChoices; $response++)
	{
		$responserow = array();
		
		//get response text
		$query = "SELECT ResponseText FROM Surveys WHERE SurveyID={$surveyid} AND QuestionID={$questionid} AND ResponseID={$response}";
		$result_text = mysql_query($query);
		
		$row = mysql_fetch_array($result_text);
		$responserow['ResponseText'] = $row['ResponseText'];
		
		//get response count
		$query = "SELECT COUNT(*) AS Count FROM Responses WHERE SurveyID={$surveyid} AND QuestionID={$questionid} AND Response='{$response}'";
		$result_count = mysql_query($query);
		
		$row = mysql_fetch_array($result_count);
		$responserow['Count'] = $row['Count'];
		
		//add both to output array
		array_push($responses, $responserow);
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
