<?php

//Dynamic form for registration, included in html
//Actual login info is a separate script

require 'php/newuser.php';

//handle sent form, call real reg function, do stuff based on return
$error = "";
$userfield = "";

if(isset($_POST['submit']))
{
	$user = $_POST['username'];
	$pass = $_POST['password'];
	
	$res = register_user($user, $pass);
	
	//successful registration
	if ($res == 0)
	{
		$return = "Registered new user {$user}!<br>";
		$url = "/index.html";
		
    	header("Location: ".$url);
    	die($return);
    }
    
	else if ($res == 81)
		$error = "Username and password must be at least 3 characters long!";
	else if ($res == 82)
		$error = "User {$user} already exists!";
		
	$userfield = $user;
}

?>

<center><font color='red'><?php echo $error; ?></font></center>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Username: <input type="text" name="username" value="<?php echo $userfield; ?>">
    Password: <input type="password" name="password" value="">
    <input type="submit" name="submit" value="Register">
</form>
