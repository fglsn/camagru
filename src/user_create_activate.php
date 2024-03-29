<?php

	require_once (__DIR__ . '/../config/include.php');
	require_once(__DIR__ . '/user_db.php');

	class UsernameExistsException extends Exception {};
	class EmailExistsException extends Exception {};
	class TokenExistsException extends Exception {};

	// -- Create user --
	function create_user($dbc, $username, $email, $hash) {
		$activation_code = md5($email.time());
		try {
			$stmt = $dbc->prepare('insert into users (username, email, password, activation_code)
								values (:username, :email, :password, :activation_code)');
			$stmt->execute(array('username' => $username,
									'email' => $email,
									'password' => $hash,
									'activation_code' => $activation_code));
			return $activation_code;
		} catch (PDOException $e) { //error thrown if username or email already in use, see unique indexes (sql)
			$err = $e->getMessage();
			if (strpos($err, 'username_index'))
				throw new UsernameExistsException();
			else if (strpos($err, 'email_index'))
				throw new EmailExistsException();
			else
				throw $e;
		}
	}

	// -- Email user --
	function send_activation_email($root_url, $sender_email, $email, $activation_code): void {
		$activation_link = $root_url . "/activate.php?activation_code=$activation_code";
		$subject = 'Please activate your account';
		$message = <<<MESSAGE
				Hi and thanks for registration!
				Please click the following link to activate your account:
				$activation_link
				MESSAGE;
		$header = 'From:' . $sender_email;
		if (!mail($email, $subject, $message, $header))
			throw new TokenExistsException();
	}

	// -- Activate user --
	function activate_user($dbc, $activation_code) {
		$sql = 'update users
				set active = 1,
				activated_at = current_timestamp
				where activation_code=:activation_code';
		$stmt = $dbc->prepare($sql);
		return $stmt->execute(array('activation_code' => $activation_code));
	}

?>
