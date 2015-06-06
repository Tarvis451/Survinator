<?php 
include_once 'getQuestions.php';
$surveyid = $_GET['surveyid'];
$questionlist = getQuestions($surveyid);

//Using for trouble shooting - Sam
if($questionlist == 0)
{
    echo "empty list";
}

if ($questionlist != 0)
{

?>
<center><b>Survey Questions</b></center>
<br><br>
<table style="width:100%; text-align:center" >
	<tr>
		<th>Question #</th>
		<th>Question Text</th>
		<th>Question Type</th>
	</tr>
	
<?php
//formatting will be weird
//maybe use lists instead?
//or new line before and after question input
    
    
    
    
foreach ($questionlist as $question)
{
	echo "<tr><td>{$question['QuestionID']}</td>";
	echo "<td><a href = '/editQuestion.html?surveyid={$surveyid}&questionid={$question['QuestionID']}'>{$question['QuestionText']}</a></td>";
	
    //Add radio button
    if ($question['QuestionType'] == "TF")
		echo 
            "<td>True/False place holder</td>";
        
       /* "<td>
            <input type="radio" name="TF"
            <?php if (isset($TF) && $TF=="T") echo                         "checked";?>
                value="T">True
                <input type="radio" name="TF"
                <?php if (isset($TF) && $TF=="F") echo                       "checked";?>        
                value="F">False
        </td>";*/
    
    
	if ($question['QuestionType'] == "MC")
		echo "<td>Multiple Choice</td>";
	if ($question['QuestionType'] == "SA")
		echo "<td><textarea rows="4" cols="40"></textarea></td>";
	echo "</tr>";
}
?>

</table> 

<?php 

} 

?>
