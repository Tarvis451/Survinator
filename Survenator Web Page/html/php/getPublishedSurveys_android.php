<?php
//Returns table of surveys that are published
//When you click one you can take the survey or view results, or delete it if it is your survey.

	include_once 'dbconnect.php';
	$dbhandle = db_connect();

	//get DB query
	$query = "SELECT SurveyID, SurveyName from SurveyList WHERE Published = 1";
	$result = mysql_query($query);

	if (mysql_num_rows($result) == 0)
	{
		die();
	}

	//build the array to send out with json
	$surveylist = array();

	while ($row = mysql_fetch_array($result))
	{
		$surveylist[] = array( "SurveyID" => $row["SurveyID"], "SurveyName" => $row["SurveyName"]);
	}
 
	db_close($dbhandle);

	echo json_encode($surveylist);
	die();
?>
