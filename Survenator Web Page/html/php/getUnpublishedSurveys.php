<?php

//Returns table of surveys that belong to you and are unpublished.
//This is so you can leave and finish an unpublished survey later.

function getUnpublishedSurveys($inuserid)
{
	//Supplied userid doesn't match your login.
	if ($_SESSION['userid'] != $inuserid)
		return -1;
	
	include 'dbconnect.php';
	$dbhandle = db_connect();
	
	//get DB query
	$userid = mysql_real_escape_string($inuserid);
	
	$query = "SELECT SurveyID, SurveyName from SurveyList WHERE UserID = {$userid} AND Published = 0";
	$result = mysql_query($query);
	
	while (!empty($result))
	{
		$row = mysql_fetch_array($result);
		array_push($surveylist, $row);
	}
	
	db_close($dbhandle);
	
	return $surveylist;
}

?>
