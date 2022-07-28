<?php
	require_once('./config/include.php');
	require_once('./src/validations.php');
	require_once('./src/posts_db.php');
	require_once('./src/comments.php');

	require_login('');
	
	header('Content-Type: application/json; charset=utf-8');

	if (is_post_request()) {
		if (isset($_POST['comment_id']) && !empty($_POST['comment_id'])) {
			remove_comment($dbc, $_POST['comment_id'], $_SESSION['user_id']);
		} else {
			echo '{"error": "Provide comment_id"}';
			exit();
		}
	} else {
		header('Location: feed.php');
		exit();
	}