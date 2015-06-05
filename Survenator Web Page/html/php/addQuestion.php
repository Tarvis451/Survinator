<?php

require_once 'dbconnect.php';
require_once 'login.php';

function getNewQuestionID($insid)
{
	$query = "SELECT QuestionID FROM Surveys WHERE SurveyID='{$insid}' ORDER BY QuestionID DESC LIMIT 1";
	$result = mysql_query($query);
	
	//no questions added yet, this will be  the first
	if(mysql_num_rows($result) == 0)
		return 1;
	
	//add 1 to highest existing qid
	$row = mysql_fetch_array($result);

	$qid = $row['QuestionID'];
	$qid++;
	
	return $qid;
}

function validateInputs($intext, $insurveyid)
{
	$text = mysql_real_escape_string($intext);
	$surveyid = mysql_real_escape_string($insurveyid);
	
	//check if requested survey to add to actually exists
	$query = "SELECT * FROM SurveyList WHERE SurveyID={$surveyid}";
	$result = mysql_query($query);
	
	if(mysql_num_rows($result) == 0)
	{
		db_close($dbhandle);
		return -203;
	}
	
	//check if this survey belongs to user adding question
	$userid = getUserID();
	
	$query = "SELECT UserID FROM SurveyList WHERE SurveyID={$surveyid}";
	$result = mysql_query($query);
	
	$row = mysql_fetch_array($result);
	
	if($row['UserID'] != $userid)
	{
		db_close($dbhandle);
		return -1;
	}

	//check if question text is valid
	if(strlen($text) < 3)
	{
		db_close($dbhandle);
		return -201;
	}

	//check if question text is already used
	$query = "SELECT QuestionText FROM Surveys WHERE SurveyID={$surveyid} AND QuestionText='{$text}'";
	$result = mysql_query($query);

	if(mysql_num_rows($result) != 0)
	{
		db_close($dbhandle);
		return -202;
	}
	
	//input is fine
	return 1;
}

function addQuestionTF($intext, $insurveyid)
{
	$dbhandle = db_connect();
	session_start();

	$text = mysql_real_escape_string($intext);
	$surveyid = mysql_real_escape_string($insurveyid);
	
	$valid = validateInputs($text, $surveyid);
	
	if ($valid != 1)
		return $valid;
	
	$questionid = getNewQuestionID($surveyid);

	//info looks good, add to db
	//Add TRUE response
	$query = "INSERT INTO Surveys(SurveyID, QuestionID, QuestionType, QuestionText, ResponseID, ResponseText) VALUES ({$surveyid}, {$questionid}, 'TF', '{$text}', 1, 'A: True')";
	$result = mysql_query($query);
	
	//Add FALSE response
	$query = "INSERT INTO Surveys(SurveyID, QuestionID, QuestionType, QuestionText, ResponseID, ResponseText) VALUES ({$surveyid}, {$questionid}, 'TF', '{$text}', 2, 'B: False')";
	$result = mysql_query($query);

	db_close($dbhandle);

	return 0;	
}

function addQuestionSA($intext, $insurveyid)
{
	$dbhandle = db_connect();
	session_start();

	$text = mysql_real_escape_string($intext);
	$surveyid = mysql_real_escape_string($insurveyid);
	
	$valid = validateInputs($text, $surveyid);
	
	if ($valid != 1)
		return $valid;
	
	$questionid = getNewQuestionID($surveyid);

	//info looks good, add to db
	$query = "INSERT INTO Surveys(SurveyID, QuestionID, QuestionType, QuestionText, ResponseID) VALUES ({$surveyid}, {$questionid}, 'SA', '{$text}', 1)";
	$result = mysql_query($query);

	db_close($dbhandle);

	return 0;	
}

?>
