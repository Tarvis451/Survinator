<?php

//Returns table of surveys that belong to you and are unpublished.
//This is so you can leave and finish an unpublished survey later.

function getUnpublishedSurveys()
{
	//Supplied userid doesn't match your login.
	//if ($_SESSION['userid'] != $inuserid)
	//	return -1;
	
	include 'dbconnect.php';
	$dbhandle = db_connect();
	
	//get DB query
	$userid = mysql_real_escape_string($_SESSION['userid']);
	
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

<table style="width:100%">
	<tr>
		<th>Unpublished Surveys</th>
	</tr>
	<tr>
<?php
$surveylist = getUnpublishedSurveys();
foreach ($surveylist as $survey)
	echo <td><a href = "/create.html?id={$survey['SurveyID']}">$survey['SurveyName']</a></td>;
?>
  	</tr>
</table> 
