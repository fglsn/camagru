<?php

	require_once("./config/include.php");
	require_once("./src/reset_pass.php");

	$info = $err_email = '';
	
	if (is_get_request()) {
		if (isset($_GET['info']) && $_GET['info'] === 'reset')
			$info = 'Thanks, the link is sent to your email!';
		echo get_template('forgot_password.php', array(
			'title' => 'Forgot Password',
			'info' => $info,
			'err_email' => $err_email,
		));
	}
	if (is_post_request()) {
		if (empty($_POST['email'])) {
			$err_email = "Please provide your email address.";
		}
		else {
			$email = input_data($_POST['email']);
			try {
				$token = create_token($dbc, $email);
				send_password_reset_link($root_url, $sender_email, $email, $token);
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
			'err_email' => $err_email,
		));
	}

	?>