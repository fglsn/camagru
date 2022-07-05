<?php

	require_once (__DIR__ . '/../config/include.php');
	require_once(__DIR__ . '/user_db.php');

	class UsernameExistsException extends Exception {};
	class EmailExistsException extends Exception {};
	class WrongPasswordException extends Exception {};
	class GeneralErrorException extends Exception {};

	function update_username($dbc, $new_username) {
		try {
			$sql = 'update users
				set username=:new_username
				where user_id=:user_id';
			$stmt = $dbc->prepare($sql);
			return $stmt->execute(array('new_username' => $new_username,
										'user_id' => $_SESSION['user_id']));
		}
		catch (PDOException $e) {
			$err = $e->getMessage();
			if (strpos($err, "username_index"))
				throw new UsernameExistsException();
			else
				throw $e;
		}
	}

	function update_email($dbc, $new_email) {
		try {
			$sql = 'update users
				set email=:new_email
				where user_id=:user_id';
			$stmt = $dbc->prepare($sql);
			return $stmt->execute(array('new_email' => $new_email,
										'user_id' => $_SESSION['user_id']));
		}
		catch (PDOException $e) {
			$err = $e->getMessage();
			if (strpos($err, "username_index") || strpos($err, "email_index"))
				throw new EmailExistsException();
			else
				throw $e;
		}
	}

	function verify_current_password($dbc, $password) {
		$user = find_user_by_id($dbc, $_SESSION['user_id']);
		if (!$user)
			throw new GeneralErrorException();
		if (!password_verify($password, $user['password']))
			throw new WrongPasswordException();
	}

	function update_password($dbc, $password) {
		$options = ['cost' => 12,];
		$hash = password_hash($password, PASSWORD_BCRYPT, $options);
		$sql = 'update users
				set password=:password
				where user_id=:user_id';
		$stmt = $dbc->prepare($sql);
		return $stmt->execute(array('password' => $hash,
									'user_id' => $_SESSION['user_id']));
	}

	function delete_user($dbc, $user_id) {
		$sql = 'delete from users where user_id=:user_id';
		$stmt = $dbc->prepare($sql);
		return $stmt->execute(array('user_id' => $user_id));
	}

	function update_session_username($new_username) {
		$_SESSION['username'] = $new_username;
	}

	function update_session_email($new_email) {
		$_SESSION['email'] = $new_email;
	}
?>