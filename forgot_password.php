<?php
	require_once("./config/include.php");
	require_once("./src/user_db.php");

	$info = '';

	if (is_get_request()) {
		echo get_template('forgot_password.php', array(
			'title' => 'Forgot Password',
			'info' => $info,
		));
	}
?>
