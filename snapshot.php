<?php
	require_once('./config/include.php');
	require_once('./src/validations.php');
	require_once('./src/images.php');
	require_once('./src/posts_db.php');

	require_login('');

	$info = $error = $description = $thumbnails = '';

	if (is_post_request()) {
		if(isset($_POST['submit'])) {
			try {
				$picture_url = $_POST['pic-url'];
				if (isset($_POST['description']) && !empty($_POST['description']))
					$description = validate_comment($_POST['description']);
				//Save all selected stickers to array
				$sticker_ids = parse_sticker_ids($_POST);

				$sticker_count = count($sticker_ids);
				// If at least one sticker selected, combine images
				if ($sticker_count > 0 && isset($picture_url) && !empty($picture_url)) {
					$original_temp_path = prepare_image($picture_url);
					$image_relative_path = save_image($original_temp_path, $sticker_ids);
					create_post($dbc, $image_relative_path, $_SESSION['user_id'], $description, 1);
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
			} catch (NoFileProvidedException $e) {
				$error = 'There is no file to upload. Please upload an image.';
			} catch (TooBigFileException $e) {
				$error = 'This file is too big. Please try again.';
			} catch (FileNotAllowedException $e) {
				$error = 'Oops, invalid filetype. Only jpeg or png files are allowed.';
			} catch (ValidationException $e) {
				$error = $e->getMessage();
			} catch (PDOException $e) {
				// $error = "Failed to load the post. Please, try again.";
				$error = $e->getMessage();
			}
		}
		if ($error)
			echo get_template('upload.php', array(
				'title' => 'New post',
				'info' => $info,
				'error' => $error,
				'thumbnails' => $thumbnails,
			));
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