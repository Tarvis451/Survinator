<?php

//Returns table of surveys that belong to you and are unpublished.
//This is so you can leave and finish an unpublished survey later.

function getUnpublishedSurveys()
{
	if (!isset($_SESSION['userid']))
		return -1;
	
	include_once 'dbconnect.php';
	$dbhandle = db_connect();
	
	//get DB query
	$userid = mysql_real_escape_string($_SESSION['userid']);
	
	$query = "SELECT SurveyID, SurveyName from SurveyList WHERE UserID = {$userid} AND Published = 0";
	$result = mysql_query($query);
	
	if (mysql_num_rows($result) == 0)
		return 0;
	
	$surveylist = array();
	
	while ($row = mysql_fetch_array($result))
	{
		array_push($surveylist, $row);
	}
	
	db_close($dbhandle);
	
	return $surveylist;
}

?>
<?php 

$surveylist = getUnpublishedSurveys();

if ($surveylist != 0)
{?>
<table style="width:100%">
	<tr>
		<th>Your Unpublished Surveys</th>
	</tr>
<?php
foreach ($surveylist as $survey)
	echo "<tr><td><center><a href = '/create.html?id={$survey['SurveyID']}'>{$survey['SurveyName']}</a></center></td></tr>";
?>
</table> 
<?php } ?>
