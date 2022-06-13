<?php

	require_once (__DIR__ . '/../config/include.php');

	class UsernameExistsException extends Exception {};
	class EmailExistsException extends Exception {};

	function create_user($dbc, $login, $email, $hash) {
		$activation_code = md5($email.time());
		try {
			$stmt = $dbc->prepare("insert into users (username, email, password, activation_code)
								values (:username, :email, :password, :activation_code)");
			$stmt->execute(array('username' => $login,
									'email' => $email,
									'password' => $hash,
									'activation_code' => $activation_code));
			return $activation_code;
		}
		catch (PDOException $e) { //error thrown if username or email already in use, see unique indexes (sql)
			$err = $e->getMessage();
			if (strpos($err, "username_index"))
				throw new UsernameExistsException();
			else if (strpos($err, "email_index"))
				throw new EmailExistsException();
			else
				throw $e;
		}
	}

	function find_user_by_username($dbc, $username) {
		$sql = 'select username, password, active, email
				from users
				where username=:username';

		$stmt = $dbc->prepare($sql);
		$stmt->execute(array('username' => $username));
		return $stmt->fetch();
	}

	function is_user_active($user) {
		return (int)$user['active'] === 1;
	}

	function login($dbc, $username, $password): bool {
		$user = find_user_by_username($dbc, $username);

		if ($user && is_user_active($user) && password_verify($password, $user['password'])) {
			// prevent session fixation attack
			session_regenerate_id();

			// set username in the session
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['username'] = $user['username'];

			return true;
		}
		return false;
	}

	function send_activation_email($root_url, $sender_email, $email, $activation_code): void {
		// create the activation link
		$activation_link = $root_url . "/activate.php?activation_code=$activation_code";
		// set email subject & body
		$subject = 'Please activate your account';
		$message = <<<MESSAGE
				Hi,
				Please click the following link to activate your account:
				$activation_link
				MESSAGE;
		// email header
		$header = "From:" . $sender_email;
		// send the email
		mail($email, $subject, nl2br($message), $header);
	}

	function activate_user($dbc, int $activation_code): bool {
		$sql = 'update users
				set active = 1,
					activated_at = CURRENT_TIMESTAMP
				where activation_code=:activation_code';

		$stmt = $dbc->prepare($sql);
		return $stmt->execute(array('activation_code' => $activation_code));
}
?>