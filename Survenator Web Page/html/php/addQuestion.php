<?php

function addQuestionTF($intext, $insid)
{
	require 'dbconnect.php';

	$dbhandle = db_connect();
	session_start();

	$text = mysql_real_escape_string($intitle);
	$sid = mysql_real_escape_string($indesc);
	
	//check if user is logged in
	if (!isset($_SESSION['userid']))
	{
		db_close($dbhandle);
		return -1;
	}
	
	$userid = $_SESSION['userid'];

	//check if name is valid
	if(strlen($text) < 3)
	{
		db_close($dbhandle);
		return -101;
	}

	//check if text is already used
	$query = "SELECT DISTINCT QuestionText FROM Surveys WHERE SurveyID={$sid}";
	$result = mysql_query($query);

	if(mysql_num_rows($result) != 0)
	{
		db_close($dbhandle);
		return -102;
	}
	
	$qid = getNewQuestionID($sid);

	//info looks good, add to db
	$query = "INSERT INTO Surveys(SurveyID, QuestionID, QuestionType, QuestionText, ResponseID, ResponseText) VALUES ({$sid}, {$qid}, 'TF', '{$text}', 1, 'A: True')";
	$result = mysql_query($query);
	
	$query = "INSERT INTO Surveys(SurveyID, QuestionID, QuestionType, QuestionText, ResponseID,R esponseText) VALUES ({$sid}, {$qid}, 'TF', '{$text}', 2, 'B: False')";
	$result = mysql_query($query);

	db_close($dbhandle);

	return 0;	
}

function getNewQuestionID($insid)
{
	$query = "SELECT QuestionID FROM Surveys WHERE SurveyID='{$insid}' ORDER BY 'QuestionID' DESC LIMIT 1";
	$result = mysql_query($query);
	
	$row = mysql_fetch_array($result);

	$qid = $row['QuestionID'];
	$qid += 1;
	
	return $qid;
}

?>
