<?php

require_once (__DIR__ . '/../config/include.php');
require_once(__DIR__ . '/user_db.php');
require_once(__DIR__ . '/post_db.php');

class FailedToLoadPostsException extends Exception {};

//username and picture itself

function load_posts($dbc, $pagenum) {
	$posts_to_load = 5;
	$pictures_total = posts_total($dbc);
	$pages_total = ceil($pictures_total / $posts_to_load);
	if ($pagenum > $pages_total || $pagenum <= 0)
		throw new FailedToLoadPostsException();
	$offset = ($pagenum - 1) * $posts_to_load;
	$sql = 'select users.username,
			posts.post_id, posts.owner_id, posts.picture_path, posts.picture_description
			from posts join users
			on posts.owner_id = users.user_id
			order by post_id desc
			limit ' . $offset . ', ' . $posts_to_load;
	$stmt = $dbc->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll();
	// throw new FailedToLoadPostException();
}

?>