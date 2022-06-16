<?php 
	require_once (__DIR__ . '/../config/include.php');
	require_once(__DIR__ . '/user_auth.php');

	class NoUserFoundException extends Exception {};
	class InvalidRequestException extends Exception {};
	class TokenExistsException extends Exception {};

	$info = $err_email = '';

	// todo: check if user already asked for reset, remove previous recordings ?
	// todo: add only token to the link, add unique index on it to password_reset_request

	// -- Forgot password --
	function create_reset_link($dbc, $email, $root_url) {
		$user = find_user_by_email($dbc, $email);
		if (!$user)
			throw new NoUserFoundException();
		$token = bin2hex(openssl_random_pseudo_bytes(16));
		try {
			$stmt = $dbc->prepare("insert into password_reset_request (user_id, requested_at, token)
								values (:user_id, :requested_at, :token)");
			$stmt->execute(array('user_id' => $user['user_id'],
								'requested_at' => date("Y-m-d H:i:s"),
								'token' => $token));
			$reset_link = $root_url . '/forgot_password.php?t=' . $token;
			return $reset_link;
		} catch (PDOException $e) {
			$err = $e->getMessage();
			if (strpos($err, "token"))
				throw new TokenExistsException();
			else
				throw $e;
		}
	}

	function send_password_reset_link($sender_email, $email, $reset_link): void {
		$subject = 'Password reset';
		$message = <<<MESSAGE
				Please click the following link to reset your password:
				$reset_link
				MESSAGE;
		$header = "From:" . $sender_email;
		mail($email, $subject, $message, $header); //Add check r no ?
	}

	function fetch_from_password_reset_table($dbc, $token) {
		try {
			$sql = "select user_id
			from password_reset_request
			where token=:token";
			$stmt = $dbc->prepare($sql);
			$stmt->execute(array("token" => $token));
			return $stmt->fetch();
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
}

	// -- Reset password --
	function reset_password($dbc, $user_id, $hash) {
		try {
			$sql = "update users
					set password=:hash
					where user_id=:user_id";
			$stmt = $dbc->prepare($sql);
			return $stmt->execute(array('user_id' => $user_id,
										'hash' => $hash));
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
?>