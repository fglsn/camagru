<?php
	require_once("./config/include.php");
	require_once("./src/user_db.php");

	$greeting = 'Thank you, account has been activated!';
	if (is_get_request()) {
		$activation_code = $_GET['activation_code'];
		$user = find_unverified_user($dbc, $activation_code);
		// if user exists and activate the user successfully
		if ($user && activate_user($dbc, $activation_code)) {
			echo get_template("login.php", array(
				'title' => 'Log in',
				'greeting' => $greeting,
			));
		}
	}
?>
