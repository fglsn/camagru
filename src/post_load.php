<?php

require_once (__DIR__ . '/../config/include.php');
require_once(__DIR__ . '/user_db.php');

function load_posts($dbc, $after_id) {
	$posts_to_load = 5;
	if (!isset($after_id))
		$where_clause = '';
	else
		$where_clause = 'where posts.post_id < :after_id';
	$sql = 'select users.username,
			posts.post_id, posts.owner_id, posts.picture_path, posts.picture_description
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

?>