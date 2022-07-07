<?php
	require_once('./config/include.php');
	require_once('./src/user_create_activate.php');
	require_once('./src/validations.php');
	require_once('./src/post_create.php');

	class NoFileProvidedException extends Exception {};
	class TooBigFileException extends Exception {};
	class FileNotAllowedException extends Exception {};

	$info = $error = '';

	$allowedTypes = [
		'image/png' => 'png',
		'image/jpeg' => 'jpg'
	];

	$upload_dir = '/uploads/';

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
					$pos = strripos($filetype, "/");
					$extension = substr($filetype, $pos + 1);
					$filename = uniqid('img_') . '.' . $extension;
					move_uploaded_file($filepath, __DIR__.$upload_dir.$filename);
					create_post($dbc, $upload_dir, $filename, $_SESSION['user_id']);
					$qparam = http_build_query(array('info' => 'uploaded'));
					header('Location: upload.php?' . $qparam);
				}

			} catch (NoFileProvidedException $e) {
				$error = 'There is no file to upload. Please upload an image.';
			} catch (TooBigFileException $e) {
				$error = 'This file is too big. Please try again.';
			} catch (FileNotAllowedException $e) {
				$error = 'Only jpeg or png files allowed.';
			} catch (PDOException $e) {
				$error = "Failed to load the post. Please, try again.";
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