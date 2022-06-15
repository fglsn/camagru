<?php

	require_once("./config/include.php");
	require_once("./src/reset_pwd.php");

	$info = $err_pass = $err_conf = $error = '';
	$submit = $password = $hash = $confirmation = '';

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
		if ($error == "" && $err_pass == "" && $err_conf == "") {
			if (isset($_SESSION['user_id_reset_pass']) && !empty($_SESSION['user_id_reset_pass'])) {
				try {
					$user_id_reset_pass = $_SESSION['user_id_reset_pass'];
					reset_password($dbc, $user_id_reset_pass, $hash);
					$qparam = http_build_query(array('info' => 'reset_success'));
					header('Location: login.php?' . $qparam);
				}
				catch (Exception $e) {
					$error = "Cannot change password. Check fields.";
				}
			}
		}
		else {
			echo get_template("reset_password.php", array('error' => $error,
													'err_pass' => $err_pass,
													'err_conf' => $err_conf,
													'info' => $info));
		}
	}
	if (is_get_request()) {
		// header('Location: forgot_password.php');
		echo get_template("reset_password.php", array('error' => $error,
													'err_pass' => $err_pass,
													'err_conf' => $err_conf,
													'info' => $info)); // or redirect to forgot_password?
	}
?>