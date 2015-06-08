<?php

	include_once 'dbconnect.php';
	$dbhandle = db_connect();
	
	//$surveyid = mysql_real_escape_string($surveyid);
	//$questionid = mysql_real_escape_string($questionid);
	$surveyid = $_POST["SurveyID"];
	$questionid = $_POST["QuestionID"];
	
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
	
	//return $responselist;
	echo json_encode($responselist);
	die();
?>
