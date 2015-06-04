<?php 
include_once 'getQuestions.php';
$questionlist = getQuestions($_GET['id']);

if ($questionlist != 0)
{

?>
<center><b>Survey Questions</b></center>
<table style="width:100%">
	<tr>
		
		<th>Question #</th>
		<th>Question Text</th>
		<th>Question Type</th>
	</tr>
	
<?php
foreach ($questionlist as $question)
	echo "<tr><td>{$question['QuestionID'}</td></tr>";
	echo "<tr><td><center><a href = '/editQuestion.html?sid={$id}&qid={$question['QuestionID']}'>{$question['QuestionText']})</a></center></td></tr>";
	if ($question['QuestionType'] == "TF")
		echo "<tr><td>True/False</td></tr>";
	if ($question['QuestionType'] == "MC")
		echo "<tr><td>Multiple Choice</td></tr>";
	if ($question['QuestionType'] == "FR")
		echo "<tr><td>Free Response</td></tr>";
?>

</table> 

<?php 

} 

?>
