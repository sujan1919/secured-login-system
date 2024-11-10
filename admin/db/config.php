<?php
// Error Reporting Turn On
ini_set('error_reporting', -1);

// Host Name
$dbhost = 'YOUR_DATABASE_HOSTNAME' ;

// Database Name
$dbname = 'YOUR_DATABASE_NAME';

// Database Username
$dbuser = 'YOUR_DATABASE_USERNAME';

// Database Password
$dbpass = 'YOUR_DATABASE_USERNAME_PASSWORD';

try {
	$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
	echo "Connection error :" . $exception->getMessage();
}
?>