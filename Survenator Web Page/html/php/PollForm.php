<?php 
include_once 'getQuestions.php';
$surveyid = $_GET['surveyid'];
$questionlist = getQuestions($surveyid);

if ($questionlist != 0)
{

?>
<br><br>
<table style="width:100%; text-align:center" >
	<tr>
		<th>Question #</th>
		<th>Question</th>
        <th>Input</th>
	</tr>
	
<?php
    
foreach ($questionlist as $question)
{
	echo "<tr><td>{$question['QuestionID']}</td>";
	echo "<td>{$question['QuestionText']}</td>";
    
    if ($question['QuestionType'] == "TF")
		echo "<td>True/False</td>";
	if ($question['QuestionType'] == "MC")
		echo "<td>Multiple Choice<br><br></td>";
	if ($question['QuestionType'] == "SA")
		echo "<td>Free Response</td>";
	echo "</tr>";
    
   // echo"<td><input type="text" name="firstname"></td>"
   
}
    
   // echo "<input type="submit" name="submit">";

</table> 

<?php 

} 

?>
