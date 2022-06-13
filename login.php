<?php
	$greeting = '';
	require_once("./config/include.php");
	echo get_template("login.php", array(
		'title' => 'Log in',
		'greeting' => $greeting,
	));
?>