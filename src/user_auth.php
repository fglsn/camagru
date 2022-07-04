<?php

	require_once(__DIR__ . '/user_db.php');
	require_once (__DIR__ . '/../config/include.php');

	class IncorrectEmailOrPwdException extends Exception {};
	class UserNotActivatedException extends Exception {};

	function is_user_active($user) {
		return (int)$user['active'] === 1;
	}

	function login($dbc, $email, $password) {
		$user = find_user_by_email($dbc, $email);
		if (!$user || !password_verify($password, $user['password']))
			throw new IncorrectEmailOrPwdException();
		if (!is_user_active($user))
			throw new UserNotActivatedException();
		// prevent session fixation attack
		session_regenerate_id();
		$_SESSION['user_id'] = $user['user_id'];
		$_SESSION['email'] = $user['email'];
		$_SESSION['username'] = $user['username'];
	}
?>