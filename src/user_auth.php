<?php 

	require_once (__DIR__ . '/../config/include.php');

	function is_user_logged_in(): bool {
		return isset($_SESSION['user_id']);
	}

	function require_login(): void {
		if (!is_user_logged_in()) {
			echo get_template("login.php", array(
				'title' => 'Log in',
				'greeting' => '',
			));
		}
	}

	// -- Log in --
	function find_user_by_email($dbc, $email) {
		$sql = 'select user_id, email, password, active
				from users
				where email=:email';
		$stmt = $dbc->prepare($sql);
		$stmt->execute(array('email' => $email));
		return $stmt->fetch();
	}

	function is_user_active($user) {
		return (int)$user['active'] === 1;
	}

	function login($dbc, $email, $password): bool {
		$user = find_user_by_email($dbc, $email);
		if ($user && is_user_active($user) && password_verify($password, $user['password'])) {
			// prevent session fixation attack
			session_regenerate_id();
			$_SESSION['user_id'] = $user['user_id'];
			$_SESSION['email'] = $user['email'];
			return true;
		}
		return false;
	}


?>