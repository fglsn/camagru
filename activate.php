<?php
	require_once("./config/include.php");
	require_once("./src/user_db.php");

	if (is_get_request()) {
		if (isset($_GET['activation_code'])) {
			$activation_code = $_GET['activation_code'];
			$user = find_user_by_activation($dbc, $activation_code);
			if ($user && $user['active'] === 0) {
				activate_user($dbc, $activation_code);
				echo get_template("login.php", array(
					'title' => 'Log in',
					'greeting' => 'Thank you, account has been activated!',
				));
			}
			else if ($user && $user['active'] === 1) {
				echo get_template("login.php", array(
					'title' => 'Log in',
					'greeting' => 'Your account is already verified!', // Redirect with query param
				));
			}
		}
		else {
			header("Location: login.php");
		}
	}
?>
