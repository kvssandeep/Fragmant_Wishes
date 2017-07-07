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
<?php
// Check if a file has been uploaded
if(isset($_FILES['uploaded_file'])) {
    // Make sure the file was sent without errors
    if($_FILES['uploaded_file']['error'] == 0) {
        // Connect to the database
        $dbLink = new mysqli('sql101.rf.gd','rfgd_18824978','Tarakkvsaus1378','rfgd_18824978_katuri');
        if(mysqli_connect_errno()) {
            die("MySQL connection failed: ". mysqli_connect_error());
        }

        // Gather all required data
    if ($_SERVER['REQUEST_METHOD'] =='POST') { 
        $flowername = mysqli_real_escape_string($dbLink,$_POST['flowername']);
    $price =  mysqli_real_escape_string($dbLink,$_POST['price']);
    $description = mysqli_real_escape_string($dbLink,$_POST['description']);
    $includes = mysqli_real_escape_string($dbLink,$_POST['includes']);
    
        $flowerimage = $dbLink->real_escape_string(file_get_contents($_FILES  ['uploaded_file']['tmp_name']));
        // Create the SQL query
    }
        $query = "
            INSERT INTO `flowers` (
                `FlowerName`, `VendorId`, `Price`, `FlowersImg` ,`Includes`,`Description`
            )
            VALUES (
                '{$flowername}', '1', '{$price}', '{$flowerimage}' ,'{$includes}','{$description}'
            )";

        // Execute the query
        $result = $dbLink->query($query);

        // Check if it was successfull
        if($result) {
            header("Location:index.php");
        }
        
    
        else {
            echo 'Error! Failed to insert the file'
            . "<pre>{$dbLink->error}</pre>";
        }
    }
    else {
        echo 'ERROR!Select a File to upload!';
    }

    
}
else {
    echo 'Error! A file was not sent!';
}

// Echo a link back to the main page
echo '<p>Click <a href="menu.php">here</a> to go back to home screen</p>';
?>

