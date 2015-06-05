<?php 
include_once 'getUnpublishedSurveys.php';

$surveylist = getUnpublishedSurveys();

if ($surveylist > 0)
{
?>

<table style="width:100%">
	<tr>
		<th>Your Unpublished Surveys</th>
	</tr>
<?php
foreach ($surveylist as $survey)
	echo "<tr><td><center><a href = '/create.html?surveyid={$survey['SurveyID']}'>{$survey['SurveyName']}</a></center></td></tr>";
?>
</table> 

<?php 
} 

?>
