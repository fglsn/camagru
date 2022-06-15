<?php 
	require_once (__DIR__ . '/../config/include.php');
	require_once(__DIR__ . '/user_auth.php');

	class NoUserFoundException extends Exception {};
	class InvalidRequestException extends Exception {};

	$info = $err_email = '';

	// todo: check if user already asked for reset, remove previous recordings ?
	// -- Forgot password --
	function create_reset_link($dbc, $email, $root_url) {
		$user = find_user_by_email($dbc, $email);
		if (!$user)
			throw new NoUserFoundException();
		$token = openssl_random_pseudo_bytes(16);
		$token = bin2hex($token);
		try {
			$stmt = $dbc->prepare("insert into password_reset_request (user_id, requested_at, token)
								values (:user_id, :requested_at, :token)");
			$stmt->execute(array('user_id' => $user['user_id'],
								'requested_at' => date("Y-m-d H:i:s"),
									'token' => $token));
			$password_request_id = $dbc->lastInsertId();
			$reset_link = $root_url . "/forgot_password.php?uid=" . $user['user_id'] . '&id=' . $password_request_id . '&t=' . $token;
			return $reset_link;
		}
		catch (PDOException $e) {
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

	function fetch_from_password_reset_table($dbc, $user_id) {
		$token = isset($_GET['t']) ? trim($_GET['t']) : '';
		$password_request_id = isset($_GET['id']) ? trim($_GET['id']) : '';
		try {
			$sql = "select id, user_id, requested_at
				from password_reset_request
				where user_id = :user_id AND 
				token = :token AND 
				id = :id";
	
			$stmt = $dbc->prepare($sql);
			$stmt->execute(array(
				"user_id" => $user_id,
				"id" => $password_request_id,
				"token" => $token
			));
			return $stmt->fetch();
		}
		catch (PDOException $e) {
			throw $e;
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