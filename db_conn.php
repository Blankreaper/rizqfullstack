<?php

$name= "localhost";
$email= "root";
$password = "";

$db_name = "rizq";

$conn = mysqli_connect($name, $email, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}