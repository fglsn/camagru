<?php
	require_once('./config/include.php');
	require_once('./src/user_create_activate.php');
	require_once('./src/validations.php');
	require_once('./src/post_create.php');
	require_once('./src/webcam.php');

	class NoFileProvidedException extends Exception {};
	class TooBigFileException extends Exception {};
	class FileNotAllowedException extends Exception {};

	require_login('');

	$info = $error = $description = '';

	$allowedTypes = [
		'image/png' => 'png',
		'image/jpeg' => 'jpg'
	];

	$upload_dir = '/uploads/';
	$sticker_paths = array();
	$sticker_dir = __DIR__ . '/static/stickers/';

	const MAX_SIZE  = 5 * 1024 * 1024; //  5MB

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
				$filesize = filesize($filepath);

				if ($filesize == 0)
					throw new NoFileProvidedException();
				if ($filesize > MAX_SIZE)
					throw new TooBigFileException();

				$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
				$filetype = finfo_file($fileinfo, $filepath);

				if(!in_array($filetype, array_keys($allowedTypes))) 
					throw new FileNotAllowedException();

				if (is_uploaded_file($_FILES['file']['tmp_name']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
					if (isset($_POST['description']) && !empty($_POST['description']))
						$description = validate_comment($_POST['description']);
					$pos = strripos($filetype, "/");
					$extension = substr($filetype, $pos + 1);
					$filename = uniqid('img_') . '.' . $extension;

					for ($i = 1; $i < 9; $i++) {
						if (isset($_POST['stick'.$i]) && $_POST['stick'.$i] === 'on')
							array_push($sticker_paths, $sticker_dir . $i . '.png');
					}
					move_uploaded_file($filepath, __DIR__.$upload_dir.$filename);
					$image = imagecreatefromjpeg(__DIR__.$upload_dir.$filename);
					$image = imagescale($image, 680);
					$sticker_count = count($sticker_paths);
					if ($sticker_count > 0) {
						for ($i = 0; $i < $sticker_count; $i++) {
							$sticker = imagecreatefrompng($sticker_paths[$i]);
							$marge_right = 540 - ($i * 170);
							$marge_bottom = 0;
							$sx = imagesx($sticker);
							$sy = imagesy($sticker);
							imagecopy($image, $sticker, imagesx($image) - $sx - $marge_right, imagesy($image) - $sy - $marge_bottom, 0, 0, imagesx($sticker), imagesy($sticker));
						}
						header('Content-type: image/png');
						imagepng($image, __DIR__.$upload_dir.$filename, 0);
						imagedestroy($image);
					}
					create_post($dbc, $upload_dir, $filename, $_SESSION['user_id'], $description);
					unlink($filepath);
					$qparam = http_build_query(array('info' => 'uploaded'));
					header('Location: upload.php?' . $qparam);
				}

			} catch (NoFileProvidedException $e) {
				$error = 'There is no file to upload. Please upload an image.';
			} catch (TooBigFileException $e) {
				$error = 'This file is too big. Please try again.';
			} catch (FileNotAllowedException $e) {
				$error = 'Only jpeg or png files allowed.';
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
		));
	}
?>