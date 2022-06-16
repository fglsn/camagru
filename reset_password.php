<?php

	require_once("./config/include.php");
	require_once("./src/reset_pwd.php");
	require_once("./src/validations.php");


	$info = $err_pass = $err_conf = $error = '';
	$submit = $password = $hash = $confirmation = '';

	if (!isset($_SESSION['user_id_reset_pass'])) {
		header('Location: login.php');
		exit();
	}
	$user_id = $_SESSION['user_id_reset_pass'];

	if (is_post_request()) {
		//Validate password
		try {
			validate_password($_POST["password"]);
			$options = ['cost' => 12,];
			$hash = password_hash($_POST["password"], PASSWORD_BCRYPT, $options);
		} catch (ValidationException $e) {
			$err_pass = $e->getMessage();
		}

		// Validate confirmation
		try {
			validate_confirmation($_POST["password"], $_POST["confirmation"]);
		} catch (ValidationException $e) {
			$err_conf = $e->getMessage();
		}
	}

	if(isset($_POST['submit'])) {
		if ($error == "" && $err_pass == "" && $err_conf == "") {
			try {
				$user_id_reset_pass = $user_id;
				reset_password($dbc, $user_id_reset_pass, $hash);
				$qparam = http_build_query(array('info' => 'reset_success'));
				header('Location: login.php?' . $qparam);
			} catch (Exception $e) {
				$error = "Cannot change password. Check fields.";
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
		echo get_template("reset_password.php", array('error' => $error,
													'err_pass' => $err_pass,
													'err_conf' => $err_conf,
													'info' => $info));
	}
?>