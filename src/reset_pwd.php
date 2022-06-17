<?php 
	require_once (__DIR__ . '/../config/include.php');
	require_once(__DIR__ . '/user_auth.php');

	class NoUserFoundException extends Exception {};
	class InvalidRequestException extends Exception {};
	class FailedToSendMail extends Exception {};

	$info = $err_email = '';

	function create_password_reset_link($dbc, $email, $root_url) {
		$user = find_user_by_email($dbc, $email);
		if (!$user)
			throw new NoUserFoundException();
		$token = bin2hex(openssl_random_pseudo_bytes(16));
		save_password_reset_request($dbc, $user['user_id'], $token);
		$reset_link = $root_url . '/forgot_password.php?t=' . $token;
		return $reset_link;
	}

	function save_password_reset_request($dbc, $user_id, $token) {
		if (!check_existing_password_reset_request($dbc, $user_id)) {
			$sql = 'insert into password_reset_request 
					(user_id, requested_at, token)
					values (:user_id, :requested_at, :token)';
			$stmt = $dbc->prepare($sql);
			$stmt->execute(array('user_id' => $user_id,
								'requested_at' => date('Y-m-d H:i:s'),
								'token' => $token));
		}
		else {
			$sql = 'update password_reset_request
					set token=:token
					where user_id=:user_id';
			$stmt = $dbc->prepare($sql);
			$stmt->execute(array('token' => $token,
								'user_id' => $user_id));
		}
	}

	function check_existing_password_reset_request($dbc, $user_id) {
		$sql = 'select user_id
				from password_reset_request
				where user_id=:user_id';
		$stmt = $dbc->prepare($sql);
		$stmt->execute(array('user_id' => $user_id));
		return $stmt->fetch();
	}

	function send_password_reset_link($sender_email, $email, $reset_link): void {
		$subject = 'Password reset';
		$message = <<<MESSAGE
				Please click the following link to reset your password:
				$reset_link
				MESSAGE;
		$header = 'From:' . $sender_email;
		if (!mail($email, $subject, $message, $header))
			throw new FailedToSendMail();
	}

	function fetch_from_password_reset_table($dbc, $token) {
		$sql = 'select user_id
		from password_reset_request
		where token=:token';
		$stmt = $dbc->prepare($sql);
		$stmt->execute(array('token' => $token));
		return $stmt->fetch();
	}

	function reset_password($dbc, $user_id, $hash) {
		$sql = 'update users
				set password=:hash
				where user_id=:user_id';
		$stmt = $dbc->prepare($sql);
		return $stmt->execute(array('user_id' => $user_id,
									'hash' => $hash));
	}
?>