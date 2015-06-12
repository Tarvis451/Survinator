<?php

require_once 'getQuestions.php';
require_once 'getResponses.php';

$surveyid = $_GET['surveyid'];
$questionid = $_GET['questionid'];

$questionlist = getQuestions($surveyid);
$question = $questionlist[$questionid];
$questiontext = $question['QuestionText'];
$questiontype = $question['QuestionType'];

?>

<b><center>Question <?php echo $questionid; ?>: </b><?php echo $questiontext; ?></center><br><br><br>

<?php

if ($questiontype == "SA")
{
	$results = getResponseList($surveyid, $questionid); ?>
	
	<table id="poll" style="width:100%; text-align:center;" >
	<tr>
		<th>Responses</th>
	</tr>
	
	<?php
	foreach ($results as $result)
		echo "<tr><td>{$result}</td></tr>";
		
	echo "</table>";
}
else
{
	$results = getResponseChoices($surveyid, $questionid); 
	
	//calculate sum for bar graph
	$sum = 0;
	
	foreach ($results as $result)
		$sum += $result['Count'];
	?>
	<table id="poll" style="width:100%; text-align:left;" >
	<tr>
		<th>Response Text</th>
		<th>Results</th>
	</tr>
	
	<?php
	foreach ($results as $result)
	{
		echo "<tr><td>{$result['ResponseText']}</td>";
		echo "<td>{$result['Count']} ";
		$barwidth = ($result['Count']/$sum) * 100;
		echo "<img src='poll.gif' width='$barwidth' height='20'></td></tr>";
	}
	
	echo "</table>";
}
	
?>
