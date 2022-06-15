<?php

	require_once("./config/include.php");
	require_once("./src/user_db.php");
	require_once("./src/reset_pass.php");

	$info = $err_pass = $err_conf = $error = '';

	if (is_post_request()) {
		//Validate password
		if (empty($_POST["password"])) {
			$err_pass = "Please provide password.";
		}
		else {
			$password = $_POST["password"];
			$number = preg_match('@[0-9]@', $password);
			$uppercase = preg_match('@[A-Z]@', $password);
			$lowercase = preg_match('@[a-z]@', $password);
			$specialChars = preg_match('@[^\w]@', $password);
			$options = ['cost' => 12, ];
			if(strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
				$err_pass = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
			} else {
				$hash = password_hash($password, PASSWORD_BCRYPT, $options);
			}
		}

		//Validate confirmation
		if (empty($_POST["confirmation"])) {
			$err_conf = "Please confirm password.";
		}
		else {
			$confirmation = $_POST["confirmation"];
			if (!password_verify($confirmation, $hash)) {
				$err_conf = "Password doesn't match.";
			}
		}
	}

	if(isset($_POST['submit'])) {
		if ($err_pass == "" && $err_conf == "") {
			try {
				reset_password($password);
				$qparam = http_build_query(array('info' => 'activation_link'));
				header('Location: login.php?' . $qparam);
			}
			catch (UsernameExistsException $e) { //error thrown if username or email already in use, see unique indexes (sql)
				$err_login = "Username already exists. Try another username." . PHP_EOL;
			}
			catch (EmailExistsException $e) {
				$err_email = "This email address is already in use. Please try another email address" . PHP_EOL;
			}
			catch (Exception $e) {
				$err_login = "The user could not be added. ".$e->getMessage();
			}
		}
	}



	if (is_get_request()) {
		if (isset($_GET['info'])) {
			if ($_GET['info'] === 'reset')
				$info = 'Thank you! Please set your new password.';
			echo get_template('reset_password.php', array(
				'title' => 'Reset Password',
				'info' => $info,
			));
		}
		else {
			echo get_template('login.php', array(
					'title' => 'Login',
					'info' => $info,
					'err_pass' => $err_pass,
					'err_conf' => $err_conf,
					'error' => $error,
				));
		}
	}
	else if (is_post_request()) {
		//Validate password
		if (empty($_POST["password"])) {
			$err_pass = "Please provide password.";
		}
		else {
			$password = $_POST["password"];
			$number = preg_match('@[0-9]@', $password);
			$uppercase = preg_match('@[A-Z]@', $password);
			$lowercase = preg_match('@[a-z]@', $password);
			$specialChars = preg_match('@[^\w]@', $password);
			$options = ['cost' => 12, ];
			if(strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
				$err_pass = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
			} else {
				$hash = password_hash($password, PASSWORD_BCRYPT, $options);
			}
		}

		//Validate confirmation
		if (empty($_POST["confirmation"])) {
			$err_conf = "Please confirm password.";
		}
		else {
			$confirmation = $_POST["confirmation"];
			if (!password_verify($confirmation, $hash)) {
				$err_conf = "Password doesn't match.";
			}
		}
	}

?>