<?php header("Location:flowers.php"); ?>
<?php
ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	
// Make sure an ID was passed
if(isset($_GET['id'])) {
    // Get the ID
    $id = intval($_GET['id']);

    // Make sure the ID is in fact a valid ID
    if($id <= 0) {
        die('The ID is invalid!');
    }
    else {
        // Connect to the database
        include 'dbconnect.php';

        // Fetch the file information
        $query = "
            SELECT FlowersImg
            FROM `flowers`
            WHERE `FlowerId` = {$id}";
        $result = $dbLink->query($query);

        if($result) {
            // Make sure the result is valid
            if($result->num_rows == 1) {
                // Get the row
                $row = mysqli_fetch_assoc($result);

                // Print headers
                header("Content-Type: image/png");
                //header("Content-Length: ". $row['size']);
                header("Content-Disposition: inline; filename=cake");

                // Print data
                echo $row['FlowerImg'];
            }
            else {
                echo 'Error! No image exists with that ID.';
            }

            // Free the mysqli resources
            @mysqli_free_result($result);
        }
        else {
            echo "Error! Query failed: <pre>{$dbLink->error}</pre>";
        }
        @mysqli_close($dbLink);
    }
}
else {
    echo 'Error! No ID was passed.';
}
?>