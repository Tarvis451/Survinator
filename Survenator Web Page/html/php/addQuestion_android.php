/* Android add question
*/
<?php

include_once 'addQuestion.php';

$surveyid = $_GET["SurveyID"];
$questiontitle = $_GET["QuestionTitle"];
$questiontype = $_GET["QuestionType"];

if($questiontype == "MC")
{
	$r1 = $_GET["r1"];
	$r2 = $_GET["r2"];
	$r3 = $_GET["r3"];
	$r4 = $_GET["r4"];

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
