<?php
	require_once("./config/include.php");
	require_once('./src/user_auth.php');
	require_login();
	header("Location: login.php");
?>