<?php
	require_once('./config/include.php');
	require_once('./src/validations.php');
	require_once('./src/images.php');
	require_once('./src/posts_db.php');

	require_login('');
	
	header('Content-Type: application/json; charset=utf-8');

	if (is_post_request()) {
		if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
			remove_post($dbc, $_POST['post_id'], $_SESSION['user_id']);
		} else {
			echo '{"error": "Provide post_id"}';
			exit();
		}
	} else {
		header('Location: feed.php');
		exit();
	}
?>
