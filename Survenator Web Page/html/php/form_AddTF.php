<?php
	require_once 'addQuestion.php';
	
	$surveyid = $_GET['surveyid'];
	
	if (isset($_POST['surveyid']))
		$surveyid = $_POST['surveyid'];
	
	$error = "";
	$fieldtext = "";
	
	if (isset($_POST['cancel']))
	{
		header("Location: /create.html?surveyid={$surveyid}");
		die("Canceled adding question");
	}
	
	if (isset($_POST['submit']))
	{
		$text = $_POST['text'];
		
		$fieldtext = $text;
		
		$ret = addQuestionTF($text,$surveyid);
		
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
	<input type="submit" name="submit" value="Add Question">
	<input type="hidden" name="surveyid" value="<?php echo $surveyid; ?>">
	<br><br><input type="submit" name="cancel" value="Cancel">
</form>
