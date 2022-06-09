<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once("./config/database.php");
session_start();

$submit = $_POST['submit'];
$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];
$confirmation = $_POST['confirmation'];

echo "TEST " . '\'' . $submit . '\' ' . $email . ' ' . $login . ' ' . $password . ' ' . $confirmation . PHP_EOL;

if ($submit != "submit" || $email === "" || $login === "" || $password === "" || $confirmation === "") {
	echo "Error: Missing fields. " . $submit . ' ' . $email . ' ' . $login . ' ' . $password . ' ' . $confirmation . PHP_EOL;
	return;
}

if ($password !== $confirmation) {
	echo "Error: Passwords doesnt match." . PHP_EOL;
	return;
}

$usr_stmnt = $dbc->prepare("SELECT * FROM users WHERE username=?");
$usr_stmnt->execute([$login]); 
$user = $usr_stmnt->fetch();
if ($user) {
	echo "Error: Username already exists." . PHP_EOL;
	return;
}

$email_stmnt = $dbc->prepare("SELECT * FROM users WHERE email=?");
$email_stmnt->execute([$email]); 
$address = $email_stmnt->fetch();
if ($address) {
	echo "Error: Email already used." . PHP_EOL;
	return;
}

$query = $dbc->prepare("INSERT INTO users (`username`, `email`, `password`)
						VALUES ('$login', '$email', '$password')");

$query->execute();
echo "OKKKKK!";
?>