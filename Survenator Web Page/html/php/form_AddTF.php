<?php
	//include_once 'login.php';
	include_once 'addQuestion.php';
	
	$SurveyID = $_GET['sid'];
	$QuestionID = $_GET['qid'];
	
	$error = "";
	$fieldtext = "";
	
	if (isset($_POST['cancel']))
	{
		header("Location: /create.html?id={$SurveyId}");
		die("Canceled adding question");
	}
	
	if (isset($_POST['submit']))
	{
		$text = $_POST['text'];
		
		$fieldtext = $text;
		
		$ret = addQuestionTF($name,$SurveyID);
		
		if ($ret == -201)
			$error = "Question title must have 3 or more characters";
		
		if ($ret == -202)
			$error = "Question title already taken";
		
		if ($ret >= 0)
		{
			header("Location: /create.html?id={$SurveyId}");
			die("Successfully added a new question to Survey #{$SurveyId}");
		}
	}
?>
 
<center><font color='red'><?php echo $error; ?></font></center>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	Question Text: <input type="text" name="text" value="<?php echo $fieldname; ?>">
	<input type="submit" name="submit" value="Add Question">
	<br><br><input type="submit" name="cancel" value="Cancel">
</form>
