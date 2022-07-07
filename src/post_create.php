<?php
	require_once (__DIR__ . '/../config/include.php');
	require_once(__DIR__ . '/user_db.php');

	function create_post($dbc, $directory, $filename, $user_id, $description, $webcam = 0) {
		$stmt = $dbc->prepare("insert into posts (owner_id, picture_path, picture_description, webcam)
								values (:owner_id, :picture_path, :picture_description, :webcam)");
		return $stmt->execute(array('owner_id' => $user_id,
							'picture_path' => $directory.$filename,
							'picture_description' => $description,
							'webcam' => $webcam	));
	}
