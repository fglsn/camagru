<?php
	require_once('./config/include.php');
	require_once('./src/user_create_activate.php');
	require_once('./src/validations.php');
	require_once('./src/posts_db.php');
	require_once('./src/images.php');

	require_login('');

	$info = $error = $thumbnails = $description = '';

	const MESSAGES = [
		UPLOAD_ERR_OK => 'File uploaded successfully',
		UPLOAD_ERR_INI_SIZE => 'File is too big to upload',
		UPLOAD_ERR_FORM_SIZE => 'File is too big to upload',
		UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
		UPLOAD_ERR_NO_FILE => 'No file was uploaded',
		UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder on the server',
		UPLOAD_ERR_CANT_WRITE => 'File is failed to save to disk.',
		UPLOAD_ERR_EXTENSION => 'File is not allowed to upload to this server',
	];

	if (is_post_request()) {
		if (isset($_POST['upload'])) {
			try {
				if (!isset($_FILES['file']))
					throw new NoFileProvidedException();

				$filepath = $_FILES['file']['tmp_name'];

				if (is_uploaded_file($_FILES['file']['tmp_name']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

					if (isset($_POST['description']) && !empty($_POST['description']))
						$description = validate_comment($_POST['description']);

					$sticker_ids = parse_sticker_ids($_POST);

					$image_relative_path = save_image($filepath, $sticker_ids);
					create_post($dbc, $image_relative_path, $_SESSION['user_id'], $description);
					$qparam = http_build_query(array('info' => 'uploaded'));
					header('Location: upload.php?' . $qparam);
				}
				else
					$error = 'There is no file to upload. Please upload an image.';

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
		$thumbnails = load_thumbnails($dbc, $_SESSION['user_id']);
		if (isset($_GET['info']) && $_GET['info'] === 'uploaded') {
			$info = 'Uploaded successfully!';
		}
		echo get_template('upload.php', array(
			'title' => 'New post',
			'info' => $info,
			'error' => $error,
			'thumbnails' => $thumbnails,
		));
	}
?>