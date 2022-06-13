<?php
	require_once('./config/include.php');
	session_destroy();
	header("Location: login.php");

	//small confirmation that user logged out
?>