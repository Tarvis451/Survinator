<?php
//Returns table of surveys that are published
//When you click one you can take the survey or view results, or delete it if it is your survey.

	include_once 'dbconnect.php';
	$dbhandle = db_connect();

	//get DB query
	$query = "SELECT SurveyID, SurveyName from SurveyList WHERE Published = 1";
	$result = mysql_query($query);

	if (mysql_num_rows($result) == 0)
		die();

	$surveylist = array();

	while ($row = mysql_fetch_array($result))
	{
		//$surveylist[$row["SurveyID"]]  = $row["SurveyName"];
		$surveylist[] = array( "SurveyID" => $row["SurveyID"], "SurveyName" => $row["SurveyName"]);
	}
 
	db_close($dbhandle);

	$blarg = array("asdasd" => "1");

	//echo json_encode($surveylist);
	//echo "what does a php do";
	//die();
	//echo json_encode($surveylist, JSON_FORCE_OBJECT);
	echo json_encode($blarg);
	die();
?>
