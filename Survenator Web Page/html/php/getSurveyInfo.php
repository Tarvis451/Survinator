<?php

require_once 'dbconnect.php';

function getSurveyInfo($insid)
{
	$dbhandle = db_connect();
	
	$surveyid = mysql_real_escape_string($insid);
	
	$query = "SELECT * from SurveyList WHERE SurveyID={$surveyid}";
	$result = mysql_query($query);
	
	$info = mysql_fetch_row($result);
	
	db_close($dbhandle);
	
	return $info;
}

function getQuestionInfo($insid, $inqid)
{
	$dbhandle = db_connect();
	
	$surveyid = mysql_real_escape_string($insid);
	$questionid = mysql_real_escape_string($inqid);
	
	$query = "SELECT * from Surveys WHERE SurveyID={$surveyid} AND QuestionID={$questionid}";
	$result = mysql_query($query);
	
	$info = mysql_fetch_row($result);
	
	db_close($dbhandle);
	
	return $info;
}

?>
