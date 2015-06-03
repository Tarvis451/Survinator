<?php
	include 'login.php';
	include 'createsurvey.php';
	
	$error = "";
	$fieldname = "";
	$fielddesc = "";
	$surveyid = 0;
	
	//if (!checkLogin())
	//{
	//	header("Location: /index.html");
	//	die("You must log in to create surveys");
	//}
	
	//if (isset($_POST['cancel']))
	//{
	//	header("Location: /MainOptions.html");
	//	die("Canceled adding survey");
	//}
	

	$name = $_POST['title'];
	$desc = $_POST['description'];
	
	$ret = addSurvey($name,$desc);
	
	if ($ret == -101)
	{
		$response["error"]=71;
		$response["message"]="Survey title must have 3 or more characters";
		echo json_encode($response);
		die();			
	}
	
	elseif ($ret == -102)
	{
		$response["error"]=72;
		$response["message"]="Survey title already taken";
		echo json_encode($response);
		die();	
	}
	
	elseif ($ret >= 0)
	{
		$surveyid = (int)$ret;
		$response["error"]=0;
		$response["message"]="Successfully created survey with id {$surveyid}";
		$response["survey_id"]=$surveyid;
		echo json_encode($response);
		die();
	}
	else
	{
		$response["error"]=1000;
		$response["message"]="Unknown error";
		echo json_encode($response);
		die();
	}
	
?>
