<?php
	require_once('./config/include.php');
	require_once('./src/user_create_activate.php');
	require_once('./src/validations.php');

	$err_email = $err_username = $err_pass = $err_conf = $error = '';
	$submit = $email = $username = $password = $hash = $confirmation = '';

	if (is_user_logged_in()) {
		header('Location: feed.php');
		exit();
	}

	if (is_post_request()) {
		// Validate username
		try {
			$username = validate_username($_POST['username']);
		} catch (ValidationException $e) {
			$err_username = $e->getMessage();
		}

		// Validate email address
		try {
			$email = validate_email($_POST['email']);
		} catch (ValidationException $e) {
			$err_email = $e->getMessage();
		}

		//Validate password
		try {
			validate_password($_POST['password']);
			$options = ['cost' => 12,];
			$hash = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
		} catch (ValidationException $e) {
			$err_pass = $e->getMessage();
		}

		// Validate confirmation
		try {
			validate_confirmation($_POST['password'], $_POST['confirmation']);
		} catch (ValidationException $e) {
			$err_conf = $e->getMessage();
		}
	}

	//Create user
	if(isset($_POST['submit'])) {
		if($err_username == '' && $err_email == '' && $err_pass == '' && $err_conf == '') {
			try {
				$activation_code = create_user($dbc, $username, $email, $hash);
				send_activation_email($root_url, $sender_email, $email, $activation_code);
				$qparam = http_build_query(array('info' => 'activation_link'));
				header('Location: login.php?' . $qparam);
			}
			catch (UsernameExistsException $e) { //error thrown if username or email already in use, see unique indexes (sql)
				$err_username = 'Username already exists. Try another username.' . PHP_EOL;
			}
			catch (EmailExistsException $e) {
				$err_email = 'This email address is already in use. Please try another email address' . PHP_EOL;
			}
			catch (FailedToSendMail $e) {
				$info = 'Failed to send email.' . PHP_EOL;
			}
			catch (Exception $e) {
				$err_username = 'The user could not be added. '.$e->getMessage();
			}
		}
	}

	echo get_template('signup.php', array(
		'title' => 'Sign up',
		'error' => $error,
		'err_email' => $err_email,
		'err_username' => $err_username,
		'err_pass' => $err_pass,
		'err_conf' => $err_conf,
		'email' => $email,
		'username' => $username,
		'password' => $password,
	));
?>