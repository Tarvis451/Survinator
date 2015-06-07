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
	/*if ($question['QuestionType'] == "TF"){
        echo "<td>
            <textarea rows="1" cols="5"></textarea>
        </td>";
		
	if ($question['QuestionType'] == "MC") {
        echo "<td>
            <p>Coming soon</p>
        </td>";
    }
		
	if ($question['QuestionType'] == "SA") {
        echo "<td>
               <textarea rows="4" cols="50"></textarea>
        </td>";
    }*/
    echo"<td><textarea></textarea></td>"
    
    echo "</tr>";
   
}
    
    echo "<input type="submit" name="submit">";

</table> 

<?php 

} 

?>
