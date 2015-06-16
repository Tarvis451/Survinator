<?php
require_once 'newuser.php';

//input from registration form
$user = $_POST['username'];
$pass = $_POST['password'];

$res = register_user($user, $pass);

if ($res == 81))
{
	$response["error"]=81;
	$response["message"]="Username and password must be at least 3 characters long!";
	echo json_encode($response);
	die();
}

if ($res == 82))
{
	$response["error"]=82;
	$response["message"]="User already exists!";
	echo json_encode($response);
	die();
}

$response["error"]=1;
$response["message"]="You are registered!";
echo json_encode($response);
die();
?>
