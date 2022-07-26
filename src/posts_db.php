<?php

	require_once (__DIR__ . '/../config/include.php');
	require_once(__DIR__ . '/user_db.php');

	function create_post($dbc, $image_relative_path, $user_id, $description, $webcam = 0) {
		$stmt = $dbc->prepare("insert into posts (owner_id, picture_path, picture_description, webcam)
								values (:owner_id, :picture_path, :picture_description, :webcam)");
		return $stmt->execute(array('owner_id' => $user_id,
							'picture_path' => $image_relative_path,
							'picture_description' => $description,
							'webcam' => $webcam	));
	}

	function load_posts($dbc, $after_id) {
		$posts_to_load = 5;
		if (!isset($after_id))
			$where_clause = '';
		else
			$where_clause = 'where posts.post_id < :after_id';
		$sql = 'select users.username,
				posts.post_id, posts.owner_id, posts.picture_path, posts.picture_description, posts.created_at
				from posts join users
				on posts.owner_id = users.user_id '
				. $where_clause .
				' order by post_id desc
				limit ' . $posts_to_load;
		$stmt = $dbc->prepare($sql);
		$stmt->execute(isset($after_id) ? array('after_id' => $after_id) : array());
		return $stmt->fetchAll();
		// throw new FailedToLoadPostException();
	}

	function load_user_posts($dbc, $user_id) {
		$sql = 'select users.username,
				posts.post_id, posts.owner_id, posts.picture_path, posts.webcam
				from posts join users
				on posts.owner_id = users.user_id
				where posts.owner_id = :user_id 
				order by post_id desc';
		$stmt = $dbc->prepare($sql);
		$stmt->execute(array('user_id' => $user_id));
		return $stmt->fetchAll();
	}

	function load_thumbnails($dbc, $user_id) {
		$sql = 'select posts.post_id, posts.owner_id, posts.picture_path, posts.webcam
				from posts
				where webcam = 1 and posts.owner_id = :user_id 
				order by post_id desc';
		$stmt = $dbc->prepare($sql);
		$stmt->execute(array('user_id' => $user_id));
		return $stmt->fetchAll();
	}

	function load_user_statistics($dbc, $user_id) {
		$sql = "select count(*) from posts where owner_id = :user_id";
		$stmt = $dbc->prepare($sql);
		$stmt->execute(array('user_id' => $user_id));
		return $stmt->fetch();
	}

	function remove_post($dbc, $post_id, $user_id) {
		$sql = "delete from posts
				where owner_id = :user_id
				and post_id = :post_id";
		$stmt = $dbc->prepare($sql);
		return $stmt->execute(array('post_id' => $post_id,
									'user_id' => $user_id));
	}

	function find_last_id($dbc) {
		$sql = 'select max(post_id) from posts;';
		$stmt = $dbc->prepare($sql);
		$stmt->execute();
		return $stmt->fetch();
	}

	function find_first_id($dbc) {
		$sql = 'select min(post_id) from posts;';
		$stmt = $dbc->prepare($sql);
		$stmt->execute();
		return $stmt->fetch();
	}

?>