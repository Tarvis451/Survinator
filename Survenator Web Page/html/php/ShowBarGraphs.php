<?php

require_once 'getQuestions.php';
require_once 'getResponses.php';

$surveyid = $_GET['surveyid'];
$questionid = $_GET['questionid'];

$questionlist = getQuestions($surveyid);
$question = $questionlist['{$questionid}'];
$questiontext = $question['QuestionTitle'];
$questiontype = $question['QuestionType'];

?>

<b><center>Question <?php echo $questionid; ?>: </b><?php echo $questiontext; ?></center>

<?php

if ($questiontype = "SA")
{
	$results = getResponseList($surveyid, $questionid); ?>
	
	<table id="poll" style="width:100%; text-align:center;" >
	<tr>
		<th>Responses</th>
	</tr>
	
	<?php
	foreach ($responses as $response);
		echo "<tr><td>{$results['Response']}</td></tr>";
		
	echo "</table>";
}
else
{
	$results = getResponseChoices($surveyid, $questionid); ?>
	
	<table id="poll" style="width:100%; text-align:center;" >
	<tr>
		<th>Response Text</th>
		<th>Results</th>
	</tr>
	
	<?php
	foreach ($responses as $response)
	{
		echo "<tr><td>{$response['ResponseText']}</td>";
		echo "<td>{$response['Count']}</td><?tr>";
	}
	
	echo "</table>";
}
	
?>
