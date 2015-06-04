<?php 
include_once 'getQuestions.php';
$questionlist = getQuestions($_GET['id']);

if ($questionlist != 0)
{

?>

<table style="width:100%">
	<tr>
		<th>Survey Questions:</th>
	</tr>
	
<?php
foreach ($questionlist as $question)
	echo "<tr><td><center><a href = '/editQuestion.html?sid={$question['SurveyID']}&qid={$question['QuestionID']}'>Question {$question['QuestionID']}: {$question['QuestionText']} ({$question['QuestionType']})</a></center></td></tr>";
?>

</table> 

<?php 

} 

?>
