<?php
	require_once('./config/include.php');
	require_once('./src/validations.php');
	require_once('./src/webcam.php');
	require_once('./src/post_create.php');

	require_login('');

	$info = $error = $description = '';
	$sticker_paths = array();
	$sticker_ids = array();
	$upload_dir = __DIR__ . '/uploads/';
	$uploads = '/uploads/';


	if (is_post_request()) {
		if(isset($_POST['submit'])) {
			$picture_url = $_POST['pic-url'];
			if (isset($_POST['description']) && !empty($_POST['description']))
				$description = validate_comment($_POST['description']);
			//Save all selected stickers to array
			for ($i = 1; $i < 9; $i++) {
				if (isset($_POST['stick'.$i]) && $_POST['stick'.$i] === 'on')
					array_push($sticker_ids, $i);
			}

			$sticker_count = count($sticker_ids);
			// If at least one sticker selected, combine images
			if ($sticker_count > 0 && isset($picture_url) && !empty($picture_url)) {
				$filename = uniqid('webcam_') . '.png';
				$filepath = $upload_dir . $filename;
				$original = prepare_image($picture_url, $filepath);
				$original = imagescale($original, 680);
				add_stickers($original, $sticker_ids);
				imagepng($original, $filepath, 0);
				create_post($dbc, $uploads, $filename, $_SESSION['user_id'], $description, 1);
				$qparam = http_build_query(array('info' => 'uploaded'));
				header('Location: upload.php?' . $qparam);
			}
			else {
				$info = "Error: No stickers selected. Please try again!";
				echo get_template('upload.php', array(
					'title' => 'New post',
					'info' => $info,
					'error' => $error,
					'thumbnails' => $thumbnails,
				));
			}
		}
	}

	if (is_get_request()) {
		if (isset($_GET['info']) && $_GET['info'] === 'uploaded') {
			$info = "Uploaded successfully!";
		}
		echo get_template('upload.php', array(
			'title' => 'New post',
			'info' => $info,
			'error' => $error,
			'thumbnails' => $thumbnails,
		));
	}

	// echo '<pre>';
	// var_dump($post_result);
	// echo '</pre>';
?>