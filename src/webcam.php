<?php

	function prepare_image($picture_url, $filepath) {
		$img = base64_decode(preg_replace("/data:image\/jpeg;base64,/", '', $picture_url));
		file_put_contents($filepath, $img);

		$image = imagecreatefromjpeg($filepath);
		imageflip($image, IMG_FLIP_HORIZONTAL);

		imagejpeg($image, $filepath, 100);
		return ($image);
	}

	const sticker_dir = __DIR__ . '/../static/stickers/';

	function add_stickers($image, $sticker_ids) {
		for ($i = 0; $i < count($sticker_ids); $i++) {
			$sticker_path = sticker_dir . $sticker_ids[$i] . '.png';
			$sticker = imagecreatefrompng($sticker_path);
			$marge_right = 520 - ($i * 170);
			$marge_bottom = 0;
			$sx = imagesx($sticker);
			$sy = imagesy($sticker);
			imagecopy($image, $sticker, imagesx($image) - $sx - $marge_right, imagesy($image) - $sy - $marge_bottom, 0, 0, imagesx($sticker), imagesy($sticker));
		}
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

?>