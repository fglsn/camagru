<?php
	require_once("./config/include.php");

	$err_email = $err_login = $err_pass = $err_conf = $error = '';
	$submit = $email = $login = $password = $confirmation = '';

	//Input fields validation  
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {  

		// Validate login
		if (empty($_POST['login'])) {
			$err_login = "Username is required";
		}
		else {
			$login = input_data($_POST["login"]);
			if (!preg_match("/^[a-zA-Z0-9_-]*$/", $login)) {
				$err_login = "Only alphabets, numbers, '_' & '-' are allowed in username.";
			}
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
			if(strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
				$err_pass = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
			} else {
				$password = hash("whirlpool", $_POST['password']);
			}
		}

		//Validate confirmation
		if (empty($_POST["confirmation"])) {
			$err_conf = "Please confirm password.";
		}
		else {
			$confirmation = hash("whirlpool", $_POST['confirmation']);
			if ($password !== $confirmation) {
				$err_conf = "Password doesn't match.";
			}
		}
	}

	function input_data($data) {  
		$data = trim($data);  
		$data = stripslashes($data);  
		$data = htmlspecialchars($data);  
		return $data;  
	}

	if(isset($_POST['submit'])) {
		if($err_login == "" && $err_email == "" && $err_pass == "" && $err_conf == "") {
			try {
				$stmt = $dbc->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
				$stmt->execute(array('username' => $login, 'email' => $email, 'password' => $password));
				header("Location: ./login.php");
			}
			catch (PDOException $e) { //error thrown if username or email already in use, see unique indexes (sql)
				$err = $e->getMessage();
				if (strpos($err, "username_index"))
					$err_login = "Username already exists. Try another username." . PHP_EOL;
				else if (strpos($err, "email_index"))
					$err_email = "This email address is already in use. Please try another email address" . PHP_EOL;
				else
					$err_login = "The user could not be added.<br>".$e->getMessage();
			}
		} else {  
			$error = "Something went wrong, please try again.";
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
		'confirmation' => $confirmation
	));
?>