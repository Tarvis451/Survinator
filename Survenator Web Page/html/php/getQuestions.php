<?php

//Returns table of questions
function getQuestions($surveyid)
{
	include_once 'dbconnect.php';
	$dbhandle = db_connect();
	
	$surveyid = mysql_get_real_escape_string($surveyid);
	
	//get DB query
	$query = "SELECT DISTINCT QuestionID, QuestionText, QuestionType from Surveys WHERE SurveyID={$surveyid}";
	$result = mysql_query($query);
	
	if (mysql_num_rows($result) == 0)
		return 0;
	
	//Turn SQL result into array for returning
	$questionlist = array();
	
	while ($row = mysql_fetch_array($result))
		array_push($questionlist, $row);
	
	db_close($dbhandle);
	
	return $questionlist;
}

//Returns table of responses for T/F or MC questions
function getResponses($surveyid, $questionid)
{
	include_once 'dbconnect.php';
	$dbhandle = db_connect();
	
	$surveyid = mysql_get_real_escape_string($surveyid);
	$questionid = mysql_get_real_escape_string($questionid);
	
	//get DB query
	$query = "SELECT ResponseID, ResponseText from Surveys WHERE SurveyID={$surveyid} AND QuestionID={$questionid}";
	$result = mysql_query($query);
	
	//Question has no answers!!
	if (mysql_num_rows($result) == 0)
		return 0;
	
	//Turn SQL result into array for returning
	$responselist = array();
	
	while ($row = mysql_fetch_array($result))
		array_push($responselist, $row);
	
	db_close($dbhandle);
	
	return $responselist;
}

?>
