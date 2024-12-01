<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['email']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$email = validate($_POST['email']);
	$pass = validate($_POST['password']);

	$re_pass = validate($_POST['re_password']);
	$name = validate($_POST['name']);

	$user_data = '&email='. $email. '&name='. $name;


	if (empty($email)) {
		header("Location: logreg.php?error=Email is required&$user_data");
	    exit();
	}else if(empty($pass)){
        header("Location: logreg.php?error=Password is required&$user_data");
	    exit();
	}
	else if(empty($re_pass)){
        header("Location: logreg.php?error=Repeat Password is required&$user_data");
	    exit();
	}

	else if(empty($name)){
        header("Location: logreg.php?error=Name is required&$user_data");
	    exit();
	}

	else if($pass !== $re_pass){
        header("Location: logreg.php?error=The confirmation password  does not match&$user_data");
	    exit();
	}

	else{

		// hashing the password
        //$pass = md5($pass);

	    $sql = "SELECT * FROM users WHERE email='$email' ";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			header("Location: logreg.php?error=The email is taken try another&$user_data");
	        exit();
		}else {
           $sql2 = "INSERT INTO users(email, password, name) VALUES('$email', '$pass', '$name')";
           $result2 = mysqli_query($conn, $sql2);
           if ($result2) {
           	 header("Location: logreg.php?success=Your account has been created successfully");
	         exit();
           }else {
	           	header("Location: logreg.php?error=unknown error occurred&$user_data");
		        exit();
           }
		}
	}
	
}else{
	header("Location: logreg.php");
	exit();
}