<?php 
	require_once("./config/include.php");
	require_once("./src/user_auth.php");

	class NoUserFoundException extends Exception {};

	$info = $err_email = '';

	function create_token($dbc, $email) {
		$user = find_user_by_email($dbc, $email);
		if (!$user)
			throw new NoUserFoundException();
		$token = openssl_random_pseudo_bytes(16);
		$token = bin2hex($token);
		// echo ($token);
		try {
			$stmt = $dbc->prepare("insert into password_reset_request (user_id, token)
								values (:user_id, :token)");
			$stmt->execute(array('user_id' => $user['user_id'],
									'token' => $token));
			return $token;
		}
		catch (PDOException $e) {
			throw $e;
		}
	}

	function send_password_reset_link($root_url, $sender_email, $email, $token): void {
		$reset_link = $root_url . "/forgot_password.php?reset=$token";
		// echo $activation_link;
		$subject = 'Password reset';
		$message = <<<MESSAGE
				Please click the following link to reset your password:
				$reset_link
				MESSAGE;
		$header = "From:" . $sender_email;
		mail($email, $subject, $message, $header); //Add check r no ?
	}

?>