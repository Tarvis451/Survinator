<?php
	require_once 'addQuestion.php';
	
	$surveyid = $_GET['surveyid'];
	
	if (isset($_POST['surveyid']))
		$surveyid = $_POST['surveyid'];
		
	if (isset($_POST['numresponses']))
		$numresponses = (int)$_POST['numresponses'];
	else
		$numresponses = 4;
	
	$responses = $_POST['responses'];
	$delete = $_POST['delete'];
	
	for ($d = 0; $d < $numresponses; $d++)
	{
		if (isset($delete[$d]))
		{
			array_splice($responses, $d, 1);
			$numresponses--;
			break;
		}
	}
	
	if (isset($_POST['addresponse']))
		$numresponses++;
	
	$error = "";
	$text = $_POST['text'];
	
		
	$fieldtext = $text;
	
	if (isset($_POST['cancel']))
	{
		header("Location: /create.html?surveyid={$surveyid}");
		die("Canceled adding question");
	}
	
	if (isset($_POST['submit']))
	{
		$text = $_POST['text'];
		
		$fieldtext = $text;
		
		$ret = addQuestionMC($text,$surveyid,$responses);
		
		if ($ret == -1)
			$error = "Survey id#{$surveyid} does not belong to you!";
		
		if ($ret == -201)
			$error = "Question title must have 3 or more characters";
		
		if ($ret == -202)
			$error = "Question title already taken";
			
		if ($ret == -203)
			$error = "Survey id#{$surveyid} does not exist!";
			
		if ($ret == -204)
			$error = "Database error";
			
		if ($ret == -205)
			$error = "You need at least two responses with at least 1 character";
		
		if ($ret >= 0)
		{
			header("Location: /create.html?surveyid={$surveyid}");
			die("Successfully added a new question to Survey #{$surveyid}");
		}
	}
?>
 
<center><font color='red'><?php echo $error; ?></font></center>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	Question Text: <input type="text" name="text" value="<?php echo $fieldtext; ?>">
	Responses:
	<input type="hidden" name="numresponses" value="<?php echo $numresponses; ?>">
	<?php
		for ($i = 0; $i < $numresponses; $i++)
		{ ?>
			<input type="text" name="responses[]" value="<?php echo $responses[$i]; ?>">
			<input type="submit" name="delete[<?php echo $i;?>]" value="(-)">
		<?php } 
	
	?>
	<input type="submit" name="addresponse" value="Add Response">
	
	<input type="submit" name="submit" value="Finish">
	<input type="hidden" name="surveyid" value="<?php echo $surveyid; ?>">
	<br><br><input type="submit" name="cancel" value="Cancel">
</form>
