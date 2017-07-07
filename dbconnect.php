<?php

	// this will avoid mysql_connect() deprecation error.
	error_reporting( ~E_DEPRECATED & ~E_NOTICE );
	// but I strongly suggest you to use PDO or MySQLi.
	
	define('DBHOST', 'sql101.rf.gd');
	define('DBUSER', 'rfgd_18824978');
	define('DBPASS', 'Tarakkvsaus1378');
	define('DBNAME', 'rfgd_18824978_katuri');
	
	$conn = mysql_connect(DBHOST,DBUSER,DBPASS);
	$dbcon = mysql_select_db(DBNAME);
	
	if ( !$conn ) {
		die("Connection failed : " . mysql_error());
	}
	
	if ( !$dbcon ) {
		die("Database Connection failed : " . mysql_error());
	}
?>

<?php
$dbLink = new mysqli('localhost', 'knallani2', 'knallani2', 'knallani2');
if(mysqli_connect_errno()) {
    die("MySQL connection failed: ". mysqli_connect_error());
}
?>