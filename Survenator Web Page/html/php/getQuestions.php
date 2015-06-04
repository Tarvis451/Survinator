<?php

//Returns table of questions

function getQuestions($surveyid)
{
	include_once 'dbconnect.php';
	$dbhandle = db_connect();
	
	//get DB query
	$query = "SELECT DISTINCT QuestionID, QuestionText, QuestionType from Surveys WHERE SurveyID={$surveyid}";
	$result = mysql_query($query);
	
	if (mysql_num_rows($result) == 0)
		return 0;
	
	$questionlist = array();
	
	while ($row = mysql_fetch_array($result))
	{
		array_push($questionlist, $row);
	}
	
	db_close($dbhandle);
	
	return $questionlist;
}

?>
