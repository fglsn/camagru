<?php
	require_once('./config/include.php');
	// Unset all of the session variables.
	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!
	require_login('');

	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}
	session_destroy();
	$qparam = http_build_query(array('info' => 'logout'));
	header('Location: login.php?' . $qparam);

?>