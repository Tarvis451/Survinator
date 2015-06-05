<?php

function getSurveyInfo($insid)
{
	require_once 'dbconnect.php';
	$dbhandle = db_connect();
	
	$surveyid = mysql_real_escape_string($insid);
	
	$query = "SELECT * from SurveyList WHERE SurveyID={$surveyid}";
	$result = mysql_query($query);
	
	$info = mysql_fetch_array($result);
	
	db_close($dbhandle);
	
	return $info;
}

function getQuestionInfo($insid, $inqid)
{
	require_once 'dbconnect.php';
	$dbhandle = db_connect();
	
	$surveyid = mysql_real_escape_string($insid);
	$questionid = mysql_real_escape_string($inqid);
	
	$query = "SELECT * from Surveys WHERE SurveyID={$surveyid} AND QuestionID={$questionid}";
	$result = mysql_query($query);
	
	$info = mysql_fetch_array($result);
	
	db_close($dbhandle);
	
	return $info;
}

?>
