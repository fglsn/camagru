<?php
	require_once('./config/include.php');
	require_once('./src/validations.php');
	require_once('./src/webcam.php');

	require_login('');

	$info = $error = '';
	$sticker_dir = __DIR__ . '/static/stickers/';
	$sticker_paths = array();
	$upload_dir = __DIR__ . '/uploads/';

	if(isset($_POST['submit'])) {
		$picture_url = $_POST['pic-url'];
		//Save all selected stickers to array
		for ($i = 1; $i < 9; $i++) {
			if (isset($_POST['stick'.$i]) && $_POST['stick'.$i] === 'on')
				array_push($sticker_paths, $sticker_dir . $i . '.png');
		}

		$sticker_count = count($sticker_paths);
		// If at least one sticker selected, combine images
		if ($sticker_count > 0 && isset($picture_url) && !empty($picture_url)) {
			$filename = 'webcam_' . uniqid() . '.png';
			$filepath = $upload_dir . $filename;
			$original = prepare_image($picture_url, $filepath);
			for ($i = 0; $i < $sticker_count; $i++) {
				$sticker = imagecreatefrompng($sticker_paths[$i]);
				$marge_right = 520 - ($i * 170);
				$marge_bottom = 0;
				$sx = imagesx($sticker);
				$sy = imagesy($sticker);
				imagecopy($original, $sticker, imagesx($original) - $sx - $marge_right, imagesy($original) - $sy - $marge_bottom, 0, 0, imagesx($sticker), imagesy($sticker));
			}

			header('Content-type: image/png');
			imagepng($original, $filepath, 0);
			imagedestroy($original);

		} else {
			$info = "Error: No stickers selected. Please try again!";
			echo get_template('upload.php', array(
				'title' => 'New post',
				'info' => $info,
				'error' => $error,
			));
		}

		// echo '<pre>';
		// var_dump($sticker_paths);
		// echo '</pre>';
	}
?>