<?php

	function prepare_image($picture_url, $upload_dir) {

		$img = base64_decode(preg_replace("/data:image\/jpeg;base64,/", '', $picture_url));
		$filename = 'webcam_' . uniqid() . '.jpeg';
		$filepath = $upload_dir . $filename;

		file_put_contents($filepath, $img);

		$image = imagecreatefromjpeg($filepath);
		imageflip($image, IMG_FLIP_HORIZONTAL);

		header('Content-type: image/jpeg');
		imagejpeg($image, $filepath, 100);
		return ($image);

	}

?>