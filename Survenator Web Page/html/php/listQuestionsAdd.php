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
{
	echo "<tr><td>{$question['QuestionID']}</td>";
	echo "<td><center><a href = '/editQuestion.html?sid={$id}&qid={$question['QuestionID']}'>{$question['QuestionText']})</a></center></td>";
	if ($question['QuestionType'] == "TF")
		echo "<td>True/False</td>";
	if ($question['QuestionType'] == "MC")
		echo "<td>Multiple Choice</td>";
	if ($question['QuestionType'] == "FR")
		echo "<td>Free Response</td>";
	echo "</tr>";
}
?>

</table> 

<?php 

} 

?>
