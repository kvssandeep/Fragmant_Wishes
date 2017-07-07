<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
    header("Location:flowers.php");
	$userLogged="False";
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		$userName="Guest";
        $userLogged="False";
	}else{
        $res=$dbLink->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	   $userRow=mysqli_fetch_assoc($res);
        $userName=$userRow['userName'];
        $userLogged="True";
    }

	// select loggedin users detail
	
?>