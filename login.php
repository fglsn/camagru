<?php
	require_once('./config/include.php');
	require_once('./src/user_auth.php');
	require_once('./src/user_create_activate.php');

	$err_email = $err_username = $err_pass = $err_conf = $error = '';
	$email = $username = $password = $hash = $confirmation = '';
	$info = '';

	if (isset($_SESSION['user_id'])) {
		header('Location: feed.php');
		exit();
	}

	if (is_post_request()) {
		// Check fields
		if (empty($_POST['username'])) {
			$err_username = 'Please fill the username field.';
		} else {
			$username = input_data($_POST['username']);
		}

		if (empty($_POST['password'])) {
			$err_pass = 'Please provide password.';	
		} else {
			$password = $_POST['password'];
		}

		if (!empty($err_pass) || !empty($err_username)) {
			echo get_template('login.php', array(
				'title' => 'Log in',
				'err_username' => $err_username,
				'err_pass' => $err_pass,
				'error' => $error,
				'info' => $info,
			));
			exit;
		}

		//Login
		try {
			login($dbc, $username, $password);
		} catch (UserNotActivatedException $e) {
			$error = 'Please activate your account first.';
		} catch (IncorrectUsernameOrPwdException $e) {
			$error = 'Invalid username or password.';
		}
		if ($error) {
			echo get_template('login.php', array(
				'title' => 'Log in',
				'err_username' => $err_username,
				'err_pass' => $err_pass,
				'error' => $error,
				'info' => $info,
			));
		} else {
			$qparam = http_build_query(array('info' => 'login_success'));
			header('Location: feed.php?' . $qparam);
		}
	}
	//todo: Add message if not activated yet or username incorrect
	else if (is_get_request()) {
		if (isset($_GET['info'])) {
			if ($_GET['info'] === 'activation_link')
				$info = "Thank you! Activation link was sent to you by the email.";
			else if ($_GET['info'] === 'already_verified')
				$info = 'Your account is already verified!';
			else if ($_GET['info'] === 'activation_success')
				$info = 'Thank you, account has been activated!';
			else if ($_GET['info'] === 'logout')
				$info = 'Logged out!';
			else if ($_GET['info'] == 'reset_success')
				$info = 'New password was updated succesfully!';
		}
		echo get_template('login.php', array(
			'title' => 'Log in',
			'err_username' => $err_username,
			'err_pass' => $err_pass,
			'error' => $error,
			'info' => $info,
		));
	}
?>