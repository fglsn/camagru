<?php
	require_once('./config/include.php');
	require_once('./src/user_auth.php');
	require_once('./src/user_db.php');

	$err_email = $err_login = $err_pass = $err_conf = $error = '';
	$email = $login = $password = $hash = $confirmation = '';
	$info = '';

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

		try {
			login($dbc, $email, $password);
		} catch (UserNotActivatedException $e) {
			$error = 'Please activate your account first.';
		} catch (IncorrectEmailOrPwdException $e) {
			$error = 'Invalid username or password.';
		}
		if ($error) {
			echo get_template('login.php', array(
				'title' => 'Log in',
				'err_email' => $err_email,
				'err_pass' => $err_pass,
				'error' => $error,
				'info' => $info,
			));
		} else {
			$qparam = http_build_query(array('info' => 'login_success'));
			header('Location: feed.php?' . $qparam);
		}
	}
	//todo: Add message if not activated yet or email incorrect
	else if (is_get_request()) {
		if (isset($_GET['info'])) {
			if ($_GET['info'] === 'activation_link')
				$info = "Thank you! Activation link was sent to you by the email.";
			else if ($_GET['info'] === 'already_verified')
				$info = 'Your account is already verified!';
			else if ($_GET['info'] === 'activation_success')
				$info = 'Thank you, account has been activated!';
			else if($_GET['info'] === 'logout')
				$info = 'Logged out!';
		}
		echo get_template('login.php', array(
			'title' => 'Log in',
			'info' => $info,
			'error' => $error,
		));
	}
?>