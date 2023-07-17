<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inialize session
session_start();

// Include database connection settings
include('../include/conn.php');

if(isset($_POST['login'])){
	
	/* capture values from HTML form */
	if(isset($_POST['username'])){
		$username = $_POST['username'];
	}
	if(isset($_POST['password'])){
		$password = $_POST['password'];
	}
	
	$sql= "SELECT username, password, levelID, status FROM user WHERE username= '$username' AND password= '$password'";
	$query = mysqli_query($conn, $sql) or die ("Error: " . mysqli_error($conn));
	$row = mysqli_num_rows($query);
	if($row == 0){
		// Jump to indexwrong page
		header('Location: indexwrong.html'); 
	}
	else{
		$r = mysqli_fetch_assoc($query);
		$username = $r['username'];
		$level = $r['levelID'];
		$status = $r['status'];
		
		if($status == "active") { 
			$_SESSION['username'] = $r['username'];
			if($level == 1) { 
				// Jump to admin dashboard
				header('Location: ../admin/dashadmin.php'); 
			} 
			elseif($level == 2) {
				// Jump to user dashboard
				header('Location: ../user/dashuser.php');
			}
		} 
		else {
			// Jump to notexist page
			header('Location: notexist.html');
		}
	}	
}
mysqli_close($conn);
?>
