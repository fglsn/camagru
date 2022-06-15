<?php

	require_once("./config/include.php");
	require_once("./src/reset_pwd.php");

	$info = $err_email = $error = '';
	
	if (is_post_request()) {
		if (empty($_POST['email'])) {
			$err_email = "Please provide your email address.";
		}
		else {
			$email = input_data($_POST['email']);
			try {
				$link = create_reset_link($dbc, $email, $root_url);
				send_password_reset_link($root_url, $sender_email, $email, $link);
				$qparam = http_build_query(array('info' => 'reset'));
				header('Location: forgot_password.php?' . $qparam);
			}
			catch (NoUserFoundException $e) {
				$info = "No user found. Please try again." . PHP_EOL;
			}
		}
		echo get_template('forgot_password.php', array(
			'title' => 'Forgot Password',
			'info' => $info,
			'error' => $error,
			'err_email' => $err_email,
		));
	}

	if (is_get_request()) {
		if (isset($_GET['uid'])) {
			$user_id = isset($_GET['uid']) ? trim($_GET['uid']) : '';
			try {
				$request_data = fetch_from_password_reset_table($dbc, $user_id);
			}
			catch (Exception $e) {
				$error = "Error fetching request, try again.";
			}
			session_regenerate_id();
			$_SESSION['user_id_reset_pass'] = $user_id;
			$qparam = http_build_query(array('info' => 'reset'));
			header('Location: reset_password.php?' . $qparam);
		}
		if (isset($_GET['info']) && $_GET['info'] === 'reset')
			$info = 'Thanks, the link is sent to your email!';
		echo get_template('forgot_password.php', array(
			'title' => 'Forgot Password',
			'info' => $info,
			'error' => $error,
			'err_email' => $err_email,
		));
	}

?>