<?php
	include 'login.php';
	include 'addSurvey.php';
	
	$error = "";
	$fieldname = "";
	$fielddesc = "";
	
	if (!checkLogin())
	{
		header("Location: /index.html");
		die("You must log in to create surveys");
	}
	
	if (isset($_POST['cancel']))
	{
		header("Location: /MainOptions.html");
		die("Canceled adding survey");
	}
	
	if (isset($_POST['submit']))
	{
		$name = $_POST['title'];
		$desc = $_POST['description'];
		
		$fieldname = $name;
		$fielddesc = $desc;
		
		$ret = addSurvey($name,$desc);
		
		if ($ret == -101)
			$error = "Survey title must have 3 or more characters";
		
		if ($ret == -102)
			$error = "Survey title already taken";
		
		if ($ret >= 0)
		{
			$surveyid = $ret;
			header("Location: /addQuestions.html?id={$surveyid}");
			die("Successfully created survey with id {$surveyid}");
		}
	}
?>
 
<center><font color='red'><?php echo $error; ?></font></center>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	Survey Title: <input type="text" name="title" value="<?php echo $fieldname; ?>">
	Survey Description: <textarea name="description" rows="5" cols="40"><?php echo $fielddesc; ?></textarea>
	<input type="submit" name="submit" value="Add Questions">
	<br><br><input type="submit" name="cancel" value="Cancel">
</form>
