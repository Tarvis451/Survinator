/* Android add question
*/
<?php

include_once 'addQuestion.php';

$surveyid = $_POST["SurveyID"];
$questiontitle = $_POST["QuestionTitle"];
$questiontype = $_POST["QuestionType"];

if($questiontype == "MC")
{
	$r1 = $_POST["r1"];
	$r2 = $_POST["r2"];
	$r3 = $_POST["r3"];
	$r4 = $_POST["r4"];

	$responses = array($r1, $r2, $r3, $r4);

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
