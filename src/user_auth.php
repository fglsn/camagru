<?php

	require_once(__DIR__ . '/user_db.php');
	require_once (__DIR__ . '/../config/include.php');

	class IncorrectUsernameOrPwdException extends Exception {};
	class UserNotActivatedException extends Exception {};

	function is_user_active($user) {
		return (int)$user['active'] === 1;
	}

	function login($dbc, $username, $password) {
		$user = find_user_by_username($dbc, $username);
		if (!$user || !password_verify($password, $user['password']))
			throw new IncorrectUsernameOrPwdException();
		if (!is_user_active($user))
			throw new UserNotActivatedException();
		// prevent session fixation attack
		session_regenerate_id();
		$_SESSION['user_id'] = $user['user_id'];
		$_SESSION['email'] = $user['email'];
		$_SESSION['username'] = $user['username'];
	}
?>