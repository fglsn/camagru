<?php
	require_once (__DIR__ . '/../config/include.php');
	require_once(__DIR__ . '/user_db.php');

	function post_comment($dbc, $post_id, $author, $comment, $commentator) {
		$sql = 'insert into comments (post_id, post_owner, comment, commentator)
							values (:post_id, :author, :comment, :commentator)';
		$stmt = $dbc->prepare($sql);
		return $stmt->execute(array('post_id' => $post_id,
			'author' => $author,
			'comment' => $comment,
			'commentator' => $commentator
		));
	}

	function load_comments($dbc, $posts) {
		if (count($posts) > 0) {
			$posts_count = (string)(count($posts) - 1);
			$first_post = $posts['0']['post_id'];
			$last_post = $posts[$posts_count]['post_id'];
			$sql = 'select post_id, post_owner, comment, commentator
					from comments
					where post_id <= :first_post and post_id >= :last_post';
			$stmt = $dbc->prepare($sql);
			$stmt->execute(array('first_post' => $first_post,
								'last_post' => $last_post));
			return $stmt->fetchAll();
		}
	}
?>	