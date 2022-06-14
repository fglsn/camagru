<?php
	require_once('./config/include.php');

	$info = '';

	if (is_get_request()) {
		if (isset($_GET['info'])) {
			if ($_GET['info'] === 'login_success')
				$info = 'Logged in successfully!';
			echo get_template('feed.php', array(
				'title' => 'Feed',
				'info' => $info,
			));
		}
		else {
			echo get_template('feed.php', array(
					'title' => 'Feed',
					'info' => $info,
				));
		}
	}
?>

<!-- pattern='^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,20}$' -->
<!-- (?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,}) -->