<style>

title, form {
  width: 100%;
  text-align: center;
}
</style>

<?php
//Create an overall form using the same syntax as the conditionals


require_once 'getQuestions.php';
//require_once 'submitResponse.php';


$surveyid = $_GET['surveyid'];
$questionlist = getQuestions($surveyid);

if (isset($_POST['cancel']))
{
	//exit and go back
}

if (isset($_POST['submit']))
{
	//submit the survey
}


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
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php
   
foreach ($questionlist as $question)
{
	echo "<tr><td>{$question['QuestionID']}</td>";
	echo "<td>{$question['QuestionText']}</td>";
	
	$questionid = $question['QuestionID'];
    
    if ($question['QuestionType'] == "TF")
    { ?>
        <td>
            <form style="">
            <input type="radio" name="response[<?php echo $questionid; ?>]" value="1">A: True
            <br>
            <input type="radio" name="response[<?php echo $questionid; ?>]" value="2">B: False
        </td><?php
    }    
        
	if ($question['QuestionType'] == "MC")
	{
		$responses = getResponses($surveyid, $questionid);
		if ($responses == 0)
			echo 'Couldnt get responses!!';
		echo '<td>';
		foreach ($responses as $response)
		{ 
			$responseid = $responses['ResponseID'];
			$responsetext = $responses['ResponseText'];
			?>
			<input type="radio" name="response[<?php echo $questionid; ?>]" value="<?php echo $responseid; ?>"><?php echo $responsetext; ?><br>
			<?php 
		}
		echo '</td>';
	}
    
	if ($question['QuestionType'] == "SA") 
	{ ?>
        	<td>
                	<textarea name="response[<?php echo $questionid; ?>]" rows="4" cols="40"></textarea>
		</td><?php
    	}
    
	echo "</tr>";
    

} ?>
    
</table> 
<input type="submit" name="submit" value="Submit Survey">
<input type="submit" name="cancel" value="Cancel">
<input type="hidden" name="surveyid" value="<?php echo $surveyid; ?>">
</form>

<?php 

} 

?>
