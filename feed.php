<?php
	require_once('./config/include.php');
	require_once('./src/post_load.php');
	$info = $posts = '';

	if (is_get_request()) {

		if (isset($_GET['after_id']) && !empty($_GET['after_id']))
			$after_id = $_GET['after_id'];
		else
			$after_id = null;

		$posts = load_posts($dbc, $after_id);
		// print "<pre>";
		// print_r($posts[0]['username']);
		// print "</pre>";

		if (isset($_GET['info'])) {
			if ($_GET['info'] === 'login_success')
				$info = 'Logged in successfully!';
			echo get_template('feed.php', array(
				'title' => 'Feed',
				'info' => $info,
				'posts' => $posts,
			));
		}
		else {
			echo get_template('feed.php', array(
					'title' => 'Feed',
					'info' => $info,
					'posts' => $posts,
				));
		}
	}
?>

<!-- pattern='^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,20}$' -->
<!-- (?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,}) -->

<!--     [1] => Array
        (
            [post_id] => 3
            [0] => 3
            [owner_id] => 1
            [1] => 1
            [picture_path] => /uploads/img_62c6a10659a5d.jpeg
            [2] => /uploads/img_62c6a10659a5d.jpeg
        )

) -->