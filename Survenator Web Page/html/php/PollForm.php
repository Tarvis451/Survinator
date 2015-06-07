<?php 
include_once 'getQuestions.php';
$surveyid = $_GET['surveyid'];
$questionlist = getQuestions($surveyid);
$counter = 1; //used to differentiate between tf radio buttons

if ($questionlist != 0)
{

?>
<br><br>
<table style="width:100%; text-align:center" >
	<tr>
		<th>Question #</th>
		<th>Question</th>
	</tr>
	
<?php
    
//start form
echo "<form>";
    
foreach ($questionlist as $question)
{
	echo "<tr><td>{$question['QuestionID']}</td>";
	//echo "<td>{$question['QuestionText']}</td>";
	if ($question['QuestionType'] == "TF"){
        echo "<td>
            {$question['QuestionText']}<br>
            <textarea rows="1" cols="5" required></textarea>
        </td>";
         $counter = $counter + 1;
    }
		
	if ($question['QuestionType'] == "MC") {
        echo "<td>
            {$question['QuestionText']}<br>
            <p>Coming soon</p>
        </td>";
    }
		
	if ($question['QuestionType'] == "SA") {
        echo "<td>
             {$question['QuestionText']}<br>
               <textarea rows="4" cols="50" required></textarea>
        </td>";
    }
		
	
    
    echo "</tr>";
   
}
    //end form
    echo "<input type="submit" name="submit">";
    echo "</form>";
?>

</table> 

<?php 

} 

?>
