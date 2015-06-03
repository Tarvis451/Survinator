<?php

//Returns table of surveys that are published
//When you click one you can take the survey or view results, or delete it if it is your survey.

function getPublishedSurveys()
{
	include 'dbconnect.php';
	$dbhandle = db_connect();
	
	//get DB query
	$query = "SELECT SurveyID, SurveyName from SurveyList WHERE Published = 1";
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

$surveylist = getPublishedSurveys();

if ($surveylist != 0)
{?>
<table style="width:100%">
	<tr>
		<th>Select Survey</th>
	</tr>
<?php
foreach ($surveylist as $survey)
	echo "<tr><td><center><a href = '/surveyOptions.html?id={$survey['SurveyID']}'>{$survey['SurveyName']}</a></center></td></tr>";
?>
</table> 
<?php } ?>
