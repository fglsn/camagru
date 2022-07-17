<?php
	require_once("./config/include.php");
	require_once('./src/posts_db.php');
	require_once("./src/validations.php");

	require_login('');

	$posts = $username = $stats = '';

	if (is_get_request()) {
		$posts = load_user_posts($dbc, $_SESSION['user_id']);
		$stats = load_user_statistics($dbc, $_SESSION['user_id']);
		$username = $_SESSION['username'];
		echo get_template('profile.php', array(
			'title' => 'Profile',
			'posts' => $posts,
			'username' => $username,
			'stats' => $stats,
		));
	}
?>