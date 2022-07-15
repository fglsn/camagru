<?php
	require_once('./config/include.php');
	require_once('./src/post_load.php');
	require_once('./src/validations.php');
	require_once('./src/comments.php');


	$info = $error = $posts = $post_id = $author = $comments = '';

	if (is_get_request()) {

		if (isset($_GET['after_id']) && !empty($_GET['after_id']))
			$after_id = $_GET['after_id'];
		else
			$after_id = null;

		$posts = load_posts($dbc, $after_id);

		$last_id = find_last_id($dbc);
		$first_id = find_first_id($dbc);

		$lateral_ids = array($last_id, $first_id);
		if (is_user_logged_in())
			$comments = load_comments($dbc, $posts);
		// print "<pre>";
		// print_r($comments);
		// print "</pre>";

		if (isset($_GET['post_id']) && is_numeric($_GET['post_id']))
			$post_id = $_GET['post_id'];

		if (isset($_GET['info'])) {
			if ($_GET['info'] === 'login_success')
				$info = 'Logged in successfully!';
			if ($_GET['info'] === 'comment_failed') {
				if (isset($_GET['error']))
					$error = $_GET['error'];
			}
			echo get_template('feed.php', array(
				'title' => 'Feed',
				'info' => $info,
				'error' => $error,
				'posts' => $posts,
				'comments' => $comments,
				'post_id' => $post_id,
				'after_id' => $after_id,
				'lateral_ids' => $lateral_ids,
			));
		}
		else {
			echo get_template('feed.php', array(
					'title' => 'Feed',
					'info' => $info,
					'error' => $error,
					'posts' => $posts,
					'comments' => $comments,
					'post_id' => $post_id,
					'after_id' => $after_id,
					'lateral_ids' => $lateral_ids,
				));
		}
	}

	if (is_post_request()) {
		if (isset($_POST['submit'])) {
			try {
				if (isset($_POST['comment']) && !empty($_POST['comment'])) {
					if (isset($_POST['after_id']) && !empty($_POST['after_id']))
						$after_id = $_POST['after_id'];
					if (isset($_POST['post_id']) && !empty($_POST['post_id']))
						$post_id = $_POST['post_id'];
					if (isset($_POST['author']) && !empty($_POST['author']))
						$author = $_POST['author'];
					$comment = validate_comment($_POST['comment']);
					post_comment($dbc, $post_id, $author, $comment, $_SESSION['username']);
					$qparam = http_build_query(array('info' => 'comment_posted', 'after_id' => $after_id, 'post_id' => $post_id, 'author' => $author));
					header('Location: feed.php?' . $qparam);
				}
				else {
					if (isset($_POST['post_id']) && !empty($_POST['post_id']))
						$post_id = $_POST['post_id'];
					$error = 'Empty comment.';
				}
			} catch (ValidationException $e) {
				$error = $e->getMessage();
			}
			if ($error) {
				$qparam = http_build_query(array('info' => 'comment_failed', 'error' => $error, 'after_id' => $after_id, 'post_id' => $post_id, 'author' => $author));
				header('Location: feed.php?' . $qparam);
			}
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