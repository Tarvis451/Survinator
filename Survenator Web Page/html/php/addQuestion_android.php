<?php
include_once 'addQuestion.php';
$surveyid = $_POST["SurveyID"];
$questiontitle = $_POST["QuestionTitle"];
$questiontype = $_POST["QuestionType"];
$numresponse = $_POST["NumResponse"];

	print_r($_POST);

if($questiontype == "MC")
{
	$responses = array();

	for($i=1; $i<=$numresponse; $i++)
	{
		array_push($responses, $_POST["r{$i}"]);
	}

	addQuestionMC($questiontitle,$surveyid,$responses);
	die();
}
else if ($questiontype == "SA")
{
	addQuestionSA($questiontitle,$surveyid);
	die();
}
else if ($questiontype == "TF")
{
	addQuestionTF($questiontitle,$surveyid);
	die();
}
?>
