<?php 
include_once 'getQuestions.php';
$surveyid = $_GET['surveyid'];
$questionlist = getQuestions($surveyid);

if ($questionlist != 0)
{

?>
<center><b>Survey Questions</b></center>
<br><br>
<table style="width:100%, text-align:center" >
	<tr>
		<th>Question #</th>
		<th>Question Text</th>
		<th>Question Type</th>
	</tr>
	
<?php
foreach ($questionlist as $question)
{
	echo "<tr><td>{$question['QuestionID']}</td>";
	echo "<td><a href = '/editQuestion.html?surveyid={$surveyid}&questionid={$question['QuestionID']}'>{$question['QuestionText']}</a></td>";
	if ($question['QuestionType'] == "TF")
		echo "<td>True/False</td>";
	if ($question['QuestionType'] == "MC")
		echo "<td>Multiple Choice</td>";
	if ($question['QuestionType'] == "SA")
		echo "<td>Free Response</td>";
	echo "</tr>";
}
?>

</table> 

<?php 

} 

?>
