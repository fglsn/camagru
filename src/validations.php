<?php

	class ValidationException extends Exception {};

	function validate_username($username) {
		$username = input_data($username);
		if (empty($username))
			throw new ValidationException("Username is required");
		if (!preg_match("/^[a-zA-Z0-9_\-]*$/", $username))
			throw new ValidationException("Only alphabets, numbers, '_' & '-' are allowed in username.");
		if (strlen($username) < 4 || strlen($username) > 9)
			throw new ValidationException("Invalid length (min 4, max 9 chars).");
		return $username;
	}

	function validate_email($email) {
		$email = input_data($email);
		if (empty($email))
			throw new ValidationException ("Please provide email address.");
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100)
			throw new ValidationException("Invalid email format or email address is too long (max 100 chars).");
		return $email;
	}

	function validate_password($password) {
		if (empty($password))
			throw new ValidationException('Please provide password.');
		$number = preg_match('@[0-9]@', $password);
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$specialChars = preg_match('@[^\w]@', $password);
		if (!(strlen($password) >= 8 && $number && $uppercase && $lowercase && $specialChars))
			throw new ValidationException('Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.');
	}

	function validate_confirmation($password, $confirmation){
		if (empty($password))
			throw new ValidationException('Please provide password.');
		if (empty($confirmation))
			throw new ValidationException('Please confirm password.');
		if (strcmp($password, $confirmation))
			throw new ValidationException("Password doesn't match.");
	}

	function validate_comment($comment) {
		if (!preg_match("/^[a-zA-Z0-9_\-+!?. ,@#:)(;'\"]*$/", $comment))
			throw new ValidationException("Forbidden characters used. Please try again");
		$comment = input_data($comment);
		if (strlen($comment) > 250)
			throw new ValidationException("Invalid length (max 250 chars).");
		return $comment;
	}
?>