<?php

	include_once 'dbconnect.php';
	$dbhandle = db_connect();
	
	$surveyid = $_POST["SurveyID"];
	
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
	
	//return $questionlist;
	echo json_encode($questionlist);
	die();

?>
