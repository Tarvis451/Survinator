<?php

require_once 'dbconnect.php';
require_once 'login.php';

function getResponses($surveyid, $questionid)
{
	$dbhandle = db_connect();
	
	$surveyid = mysql_real_escape_string($surveyid);
	$questionid = mysql_real_escape_string($questionid);
	
	$query = "SELECT Response FROM Responses WHERE SurveyID={$surveyid} AND QuestionID={$questionid}";
	$result = mysql_query($query);
	
	if (mysql_num_rows($result) == 0)
		return 0;
	
	//Turn SQL result into array for returning
	$questionlist = array();
	
	while ($row = mysql_fetch_array($result))
		array_push($responses, $row);
	
	db_close($dbhandle);
	
	return $responses;
}

?>