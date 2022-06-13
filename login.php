<?php
	require_once('./config/include.php');
	require_once('./src/user_auth.php');
	require_once('./src/user_db.php');

	$err_email = $err_login = $err_pass = $err_conf = $error = '';
	$email = $login = $password = $hash = $confirmation = '';
	$greeting = '';

	if (is_post_request()) {  
		// Validate login
		if (empty($_POST['email'])) {
			$err_email = 'Please fill the email field.';
		} else {
			$email = input_data($_POST['email']);
		}

		if (empty($_POST['password'])) {
			$err_pass = 'Please provide password.';	
		} else {
			$password = $_POST['password'];
		}	

		if (!login($dbc, $email, $password)) {
			$error = 'Invalid username or password.';
			echo get_template('login.php', array(
				'title' => 'Log in',
				'err_email' => $err_email,
				'err_pass' => $err_pass,
				'error' => $error,
				'greeting' => $greeting,
			));
		}
		else {
			echo get_template('feed.php', array(
				'title' => 'Feed',
			));
		}
	}
	else if (is_get_request()) {
		echo get_template('login.php', array(
			'title' => 'Log in',
			'greeting' => $greeting,
		));
	}
?>