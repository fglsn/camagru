<?php

function like($dbc, $post_id, $user_id) {
	$stmt = $dbc->prepare("insert into likes (post_id, user_id)
								values (:post_id, :user_id)
								on duplicate key update like_id = like_id");
	return $stmt->execute(array('post_id' => $post_id,
						 		'user_id' => $user_id));
}

function dislike($dbc, $post_id, $user_id) {
	$stmt = $dbc->prepare("delete from likes
							where post_id = :post_id and user_id = :user_id");
	return $stmt->execute(array('post_id' => $post_id,
						 		'user_id' => $user_id));
}

function post_like_count($dbc, $post_id) {
	$stmt = $dbc->prepare("select count(*) from likes where post_id = :post_id");
	$stmt->execute(array('post_id' => $post_id));
	$result = $stmt->fetch();
	return $result['0'];
}

function posts_like_counts($dbc, $posts) {
	if (count($posts) > 0) {
		$posts_count = (string)(count($posts) - 1);
		$first_post = $posts['0']['post_id'];
		$last_post = $posts[$posts_count]['post_id'];
		$sql = 'select post_id, count(*) as like_count
				from likes
				where post_id <= :first_post and post_id >= :last_post
				group by post_id';
		$stmt = $dbc->prepare($sql);
		$stmt->execute(array('first_post' => $first_post,
							'last_post' => $last_post));
		return $stmt->fetchAll();
	}
}

function liked_posts($dbc, $posts, $user_id) {
	if (count($posts) > 0) {
		$posts_count = (string)(count($posts) - 1);
		$first_post = $posts['0']['post_id'];
		$last_post = $posts[$posts_count]['post_id'];
		$sql = 'select post_id
				from likes
				where post_id <= :first_post and post_id >= :last_post
				and user_id = :user_id';
		$stmt = $dbc->prepare($sql);
		$stmt->execute(array('first_post' => $first_post,
							'last_post' => $last_post,
							'user_id' => $user_id));
		return $stmt->fetchAll();
	}
}

?>