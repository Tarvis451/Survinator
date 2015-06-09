<?php 
include_once 'getQuestions.php';
$surveyid = $_GET['surveyid'];
$questionlist = getQuestions($surveyid);

if ($questionlist != 0)
{

?>
<style>
table, th, td {
	border: 1px solid black;
}
</style>

<br><br>
<table id="poll" style="width:100%; text-align:center;" >
	<tr>
		<th>Question #</th>
		<th>Question Text</th>
		<th>Results</th>
	</tr>
	
<?php
foreach ($questionlist as $question)
{
	echo "<tr><td>{$question['QuestionID']}</td>";
	echo "<td>{$question['QuestionText']}</td>";
	
	//Query number of yes' and no's
	if ($question['QuestionType'] == "TF") {
		//each query counts the number of true and false questions there are
		//$queryT = 
		//$queryF = 
		
		?>
		
		<td>
		Yes:    <img src="poll.gif"
				width='<?php echo(100*round($queryT/($queryF+$queryT),2)); ?>' height='20'>
				<?php echo(100*round($queryT/($queryF+$queryT),2)); ?>%
				<br>
				
		No:     <img src="poll.gif"
				width='<?php echo(100*round($queryF/($queryF+$queryT),2)); ?>' height='20'>
				<?php echo(100*round($queryF/($queryF+$queryT),2)); ?>%
		
		</td>
		
		<?php
	}
		
	
	//Query number using response 1 with this question on this survey
	if ($question['QuestionType'] == "MC") {
		//Each query counts the number of users that voted for each response
		//$query1 =
		//$query2 =
		//$query3 =
		//$query4 =
		
		?>
		
		<td>
		A:    <img src="poll.gif"
				width='<?php echo(100*round($query1/( $query1 + $query2 + $query3 + $query4 ),2)); ?>' height='20'>
				<?php echo(100*round($queryT/($queryF+$queryT),2)); ?>%
				<br>
				
		B:     <img src="poll.gif"
				width='<?php echo(100*round($query2/( $query1 + $query2 + $query3 + $query4 ),2)); ?>' height='20'>
				<?php echo(100*round($queryF/($queryF+$queryT),2)); ?>%
				<br>
				
		C:     <img src="poll.gif"
				width='<?php echo(100*round($query3/( $query1 + $query2 + $query3 + $query4 ),2)); ?>' height='20'>
				<?php echo(100*round($queryF/($queryF+$queryT),2)); ?>%
				<br>
		
		D:     <img src="poll.gif"
				width='<?php echo(100*round($query4/( $query1 + $query2 + $query3 + $query4 ),2)); ?>' height='20'>
				<?php echo(100*round($queryF/($queryF+$queryT),2)); ?>%
		</td>
		
		<?php
		
	}
	
	//list 4 most recent responses
	if ($question['QuestionType'] == "SA") {
		//query db for short answers for this question
		//$query = 
	}
	
	
	
	echo "</tr>";
}
?>

</table> 

<?php 

} 

?>
