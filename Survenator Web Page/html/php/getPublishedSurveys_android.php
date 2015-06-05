<?php
//Returns table of surveys that are published
//When you click one you can take the survey or view results, or delete it if it is your survey.
	require_once 'getPublishedSurveys.php';
	
	$surveylist = getPublishedSurveys();

	echo json_encode($surveylist);
	die();
?>
