<?php

$DB_HOST = 'mysql:host=localhost';
$DB_USER = 'root';
$DB_PASSWORD = '452565';


try {
  $conn = new PDO($DB_HOST, $DB_USER, $DB_PASSWORD);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = file_get_contents("./init.sql");
  $conn->exec($sql);
  echo "Connected successfully";
} 
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
$conn = null;

// try {
// 	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
// 	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 	$sql = $conn->prepare("CREATE TABLE IF NOT EXISTS camagru_db.`users` (
// 		`id` INT AUTO_INCREMENT PRIMARY KEY
// 	)");
// 	$sql->execute();
// 	echo "Table created";
// }
// catch(PDOException $e) {
// 	echo "Table not created: " . $e->getMessage();
// }
// $conn = null;

?>