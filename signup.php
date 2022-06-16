<?php
	require_once("./config/include.php");
	require_once("./src/user_db.php");

	$err_email = $err_login = $err_pass = $err_conf = $error = '';
	$submit = $email = $login = $password = $hash = $confirmation = '';

	//Input fields validation  
	if (is_post_request()) {  
		// Validate login
		if (empty($_POST['login'])) {
			$err_login = "Username is required";
		}
		else {
			$login = input_data($_POST["login"]);
			if (!preg_match("/^[a-zA-Z0-9_-]*$/", $login))
				$err_login = "Only alphabets, numbers, '_' & '-' are allowed in username.";
			if (strlen($login) < 3 || strlen($login) > 100)
				$err_login = "Invalid length (min 3, max 100 chars).";
		}

		// Validate email address
		if (empty($_POST["email"])) {
			$err_email = "Please provide email address.";
		}
		else {
			$email = input_data($_POST["email"]);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
				$err_email = "Invalid email format or email address is too long (max 100 chars).";
			}
		}

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

	//Create user
	if(isset($_POST['submit'])) {
		if($err_login == "" && $err_email == "" && $err_pass == "" && $err_conf == "") {
			try {
				$activation_code = create_user($dbc, $login, $email, $hash);
				send_activation_email($root_url, $sender_email, $email, $activation_code);
				$qparam = http_build_query(array('info' => 'activation_link'));
				header('Location: login.php?' . $qparam);
			}
			catch (UsernameExistsException $e) { //error thrown if username or email already in use, see unique indexes (sql)
				$err_login = "Username already exists. Try another username." . PHP_EOL;
			}
			catch (EmailExistsException $e) {
				$err_email = "This email address is already in use. Please try another email address" . PHP_EOL;
			}
			catch (FailedToSendMail $e) {
				$info = "Failed to send email." . PHP_EOL;
			}
			catch (Exception $e) {
				$err_login = "The user could not be added. ".$e->getMessage();
			}
		}
	}

	echo get_template("signup.php", array(
		'title' => 'Sign up',
		'error' => $error,
		'err_email' => $err_email,
		'err_login' => $err_login,
		'err_pass' => $err_pass,
		'err_conf' => $err_conf,
		'email' => $email,
		'login' => $login,
		'password' => $password,
	));
?>