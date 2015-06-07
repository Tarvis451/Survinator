<style>

title, form {
  width: 100%;
  text-align: center;
}
</style>

<?php
//Create an overall form using the same syntax as the conditionals


include_once 'getQuestions.php';
include_once 'MultipleChoicePrint.php';     //script to print multiple choice options

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
    
    if ($question['QuestionType'] == "TF"){ ?>
        <td>
            <form style="">
            <input type="radio" name="sex" value="T" checked>True
            <br>
            <input type="radio" name="sex" value="F">False
            </form>
        </td><?php
    }    
        
	if ($question['QuestionType'] == "MC")
		//run script
    
	if ($question['QuestionType'] == "SA") { ?>
        <td>
            <form>
                <textarea rows="4" cols="40"></textarea>
            </form>
        </td> <?php
    }
    
	echo "</tr>";
    
   // echo"<td><input type="text" name="firstname"></td>"
   
}
    
   // echo "<input type="submit" name="submit">";
    ?>  
    
    
    <?php
?>
</table> 

<input type="submit" name="submit">

<?php 

} 

?>
