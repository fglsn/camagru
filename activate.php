<?php
	require_once('./config/include.php');
	require_once('./src/user_create_activate.php');

	if (is_get_request()) {
		if (isset($_GET['activation_code'])) {
			$activation_code = $_GET['activation_code'];
			$user = find_user_by_activation($dbc, $activation_code);
			if ($user && $user['active'] === 0) {
				activate_user($dbc, $activation_code);
				$qparam = http_build_query(array('info' => 'activation_success'));
				header('Location: login.php?' . $qparam);
			}
			else if ($user && $user['active'] === 1) {
				$qparam = http_build_query(array('info' => 'already_verified'));
				header('Location: login.php?' . $qparam);
			} else {
				header('Location: login.php');
			}
		}
		else {
			header('Location: login.php');
		}
	}
?>
