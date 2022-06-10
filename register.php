<?php

// - debugs:
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once("./config/database.php");

if ($_POST['submit'] !== "submit" || empty($_POST['email']) || empty($_POST['login']) || empty($_POST['password']) || empty($_POST['confirmation'])) {
	echo "Error: Missing fields. " . PHP_EOL;
	return;
}
else {
	$submit = $_POST['submit'];
	$email = $_POST['email'];
	$login = $_POST['login'];
	$password = hash("whirlpool", $_POST['password']);
	$confirmation = hash("whirlpool", $_POST['confirmation']);
}

//echo $password . '    ' . $confirmation;
// echo "TEST: " . 'Submit value: \'' . $submit . '\' Email: ' . $email . ' Login: ' . $login . ' Pswd: ' . $password . ' Conf: ' . $confirmation . PHP_EOL;


if ($password !== $confirmation) {
	echo "Error: Passwords doesnt match." . PHP_EOL;
	return;
}


try {
	$stmt = $dbc->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
	$stmt->execute(array('username' => $login, 'email' => $email, 'password' => $password));
	echo "Inserted" . PHP_EOL;
}
catch (PDOException $e) { //error thrown if username or email already in use, see unique indexes (sql)
	$err = $e->getMessage();
	if (strpos($err, "username_index"))
		echo "Username already exists. Try another username." . PHP_EOL;
	else if (strpos($err, "email_index"))
		echo "This email address is already in use. Please try another email address" . PHP_EOL;
	else
		echo "The user could not be added.<br>".$e->getMessage();
}
?>