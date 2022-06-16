<?php

	class ValidationException extends Exception {};

	function validate_username($username) {
		if (empty($username))
			throw new ValidationException("Username is required");
		if (!preg_match("/^[a-zA-Z0-9_-]*$/", $username))
			throw new ValidationException("Only alphabets, numbers, '_' & '-' are allowed in username.");
		if (strlen($username) < 4 || strlen($username) > 100)
			throw new ValidationException("Invalid length (min 4, max 100 chars).");
		}

	function validate_email($email) {
		if (empty($email))
			throw new ValidationException ("Please provide email address.");
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100)
			throw new ValidationException("Invalid email format or email address is too long (max 100 chars).");
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

	function validate_confirmation($confirmation, $hash){
		if (empty($confirmation))
			throw new ValidationException('Please confirm password.');
		if (!password_verify($confirmation, $hash))
			throw new ValidationException("Password doesn't match.");
	}

?>