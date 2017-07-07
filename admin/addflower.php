<?php
	ob_start();
	session_start();
	require_once '../dbconnect.php';
	$userLogged="False";
	// if session is not set this will redirect to login page
    if(isset($_SESSION['userType'])){
        $userType=$_SESSION['userType'];
        if($userType=="user")
            header("Location: ../index.php");
    }else{
        header("Location: ../index.php");
    }
	
	// select loggedin users detail
	
?>
<!DOCTYPE html>

<html>
<head>
    <title>Upload File</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" >
    
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    
    <link rel="stylesheet" type="text/css" href="../check/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="../check/fonts/font-awesome-4.2.0/css/font-awesome.min.css" />
		
		<link rel="stylesheet" type="text/css" href="../check/css/checkout-cornerflat.css" />
        
        
        
        <link rel="stylesheet" type="text/css" href="../check/css/component.css" />
        <script src="../jquery-1.11.3-jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        
        
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="../css/demo.css" />
		<link rel="stylesheet" type="text/css" href="../css/component.css" />
    
    <style >
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
            height: 67px;
        }

        li {
            float: left;
        }

            li a {
                display: block;
                color: white;
                text-align: center;
                padding: 25px 16px;
                text-decoration: none;
            }

                li a:hover:not(.active) {
                    background-color: #111;
                }

        .active {
            background-color: darkslategrey;
        }
    </style>
</head>
<body bgcolor="">

    
    <div class="container">
			
	       <ul>
                <li style=" font-size:20px;">
                    <a href="#">Admin Panel</a>
                </li>
                <li>
                    <a href="flowers.php">Flowers</a>
                </li>
                <li class="active">
                    <a href="cakes.php">Cakes</a>
                </li>
            
                <li  style="float:right">
                    <a class="active" href="../logout.php?logout">Sign Out</a>
                    
                </li>
            </ul>
        </div>
    <div>
    <form action="add_file1.php" method="post" enctype="multipart/form-data">
        
        <table align="center">
            <tr><td style="text-align:center;" colspan="2"><h3>Flower Details</h1></td></tr>
            <tr><td>Flower Name:</td><td><input type="text" id="flowername" name=flowername></td></tr>
            <tr><td>Price:</td><td><input type="text" id="price" name="price"></td></tr>
            <tr><td>Description:</td><td><textarea rows="4" cols="50" name="description" id ="description"></textarea></td></tr>
            <tr><td>Includes:</td><td><textarea rows="4" cols="50" name="includes" id ="includes"></textarea><br></td></tr>
            <tr><td>File:</td><td><input type="file" name="uploaded_file"></td></tr>
            <tr><td style="text-align:center;" colspan="2"><input type="submit" value="Upload file"></td></tr>
        </table>
        
    
    </form>
    </div>
    
</body>
</html>