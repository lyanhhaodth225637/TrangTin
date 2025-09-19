<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "trangtin_baiviet";	
	
	$connect = new mysqli($servername, $username, $password, $dbname);	

	if ($connect->connect_error) {
	    die("Không kết nối :" . $conn->connect_error);
	    exit();
	}	
?>
