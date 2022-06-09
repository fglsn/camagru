<?php
	require_once("./config/database.php");

	// $query = $dbc->prepare("SELECT * FROM `users`");
	// $query->execute();

	// $fetch_username = $query->fetchAll();
	// print_r($fetch_username);

	header("Location: ./templates/login.php");
?>