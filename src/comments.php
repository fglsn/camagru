<?php
	require_once (__DIR__ . '/../config/include.php');
	require_once(__DIR__ . '/user_db.php');

	function post_comment($dbc, $post_id, $post_owner_id, $comment, $commentator_id) {
		$sql = 'insert into comments (post_id, post_owner_id, comment, commentator_id)
							values (:post_id, :post_owner_id, :comment, :commentator_id)';
		$stmt = $dbc->prepare($sql);
		return $stmt->execute(array('post_id' => $post_id,
			'post_owner_id' => $post_owner_id,
			'comment' => $comment,
			'commentator_id' => $commentator_id
		));
	}

	function load_comments($dbc, $posts) {
		if (count($posts) > 0) {
			$posts_count = (string)(count($posts) - 1);
			$first_post = $posts['0']['post_id'];
			$last_post = $posts[$posts_count]['post_id'];
			$sql = 'select users.username,
					comments.post_id, comments.post_owner_id, comments.comment, comments.commentator_id, comments.created_at
					from comments join users
					on comments.commentator_id = users.user_id
					where post_id <= :first_post and post_id >= :last_post
					order by comments.created_at';
			$stmt = $dbc->prepare($sql);
			$stmt->execute(array('first_post' => $first_post,
								'last_post' => $last_post));
			return $stmt->fetchAll();
		}
	}

	function send_notification($email, $commentator, $subject, $qparam): void {
		$message = <<<MESSAGE
				Your post just recieved new comment from the user @$commentator.
				You can check it out here: http://localhost:8080/camagru/feed.php?$qparam'
				MESSAGE;
		$sender_email = 'no-reply@camagru.com';
		$header = 'From:' . $sender_email;
		mail($email, $subject, $message, $header);
	}
?>