<?php
ini_set('session.gc_maxlifetime', 30);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(30);
session_start();

include '../config.php';
$errmsg;
if(isset($_POST['username']) && isset($_POST['password'])){

	$username=$_POST['username'];
	$password= $_POST['password'];
	$email_verify=false;

	if(strlen($username)>0 && strlen($password)>0){
		$sql= "SELECT * FROM Users WHERE Username =('".$username."' ) ";
		$result = $connection -> query($sql);
		$login=false;
		$correct_password=true;
		$correct_user=false;
		while($row = $result->fetch_assoc()) {
				$correct_user=true;
			if(password_verify($password, $row["password"])){
				if($row["verified"]==1){

				$_SESSION["id"] = $row["UserId"];
				$_SESSION["username"] = $row["Username"];
				$_SESSION["role"] = $row["Role"];
				$email_verify=true;
				$login=true;

				}



			}
			else{
				$correct_password=false;
			}
			
	      
	    }
	    if($login  &&$email_verify){
	    	echo "login success";
	    	header("Location: http://yushae.com/");
	    }
	    else{
	    	if($correct_user){
		    	if(!$email_verify){
		    		$errmsg="please verify your email ";
		    	}
		    	if(!$correct_password){
		    		$errmsg="Incorrect password or username";
		    	}
	   		}
	    else{
	    	$errmsg="Incorrect username";
	    }
	    	
	    	session_unset();
	    	session_destroy();
	    }
	}
	else{

		$errmsg= "please fill in your username and password";
	}





}











?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../Styles/style.css?v1.05">
	
</head>
<body  onload="test.reset();">
<div id= "wrapper">
<h1>Login</h1>


<br>
<div class ="form">
<div id="message">
<?php 
if (isset($errmsg)) {
	echo $errmsg;
}



?>
</div>
<form   novalidate action="" id ="test" method="POST" autocomplete="off class="form-inpister">

	
	<label>UserName</label>
	<input class="form-inp" type="text"  name="username" placeholder="UserName" >
	
	<label>Password</label>
	<input type="Password" name="password" class="form-inp" placeholder="Password">


	<input  type="submit" name="submit2" class="subbtn" value="Login">

</form>
<br>
<button onclick="window.location.href = 'http://yushae.com/Register';" class="subbtn">Create a Account</button>
</div>
</div>

</body>
</html>