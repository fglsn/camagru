<?php
	require_once("./config/include.php");
	require_once('./src/posts_db.php');
	require_once("./src/validations.php");

	require_login('');

	$posts = $username = $stats = '';

	if (is_get_request()) {
		if (isset($_GET['user']) && is_numeric($_GET['user']))
			$user_id = $_GET['user'];
		else
			$user_id = $_SESSION['user_id'];
		$posts = load_user_posts($dbc, $user_id);
		$total_posts = load_user_statistics($dbc, $user_id)['0'];
		$username = find_username_by_id($dbc, $user_id)['0'];
		echo get_template('profile.php', array(
			'title' => 'Profile',
			'posts' => $posts,
			'username' => $username,
			'total_posts' => $total_posts,
		));
	}
?>