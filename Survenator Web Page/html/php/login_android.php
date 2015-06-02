<?php
    require 'login.php';
    
    $user = $_POST['username'];
    $pass = $_POST['password'];
    
    $ret = login($user, $pass);
    
    //fail if user does not exist
    if ($ret == 91)
    {
	    $response["error"] = 91;
	    $response["message"] = "Specified user does not exist";
            echo json_encode($response);
	    die();
    }
    
    //fail if wrong password
    if($ret == 92)
    {
	    $response["error"] = 92;
            $response["message"] = "Incorrect password";
            echo json_encode($response);
	    die();
    }
    
    //success
    if($ret == 0)
    {
    	$response["error"] = 0;
    	$response["message"] = "Logged in";
    	$response["userid"] = $_SESSION["userid"];
    	echo json_encode($response);
    	die();
    }
    
?>
