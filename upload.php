<?php
	require_once('./config/include.php');
	require_once('./src/user_create_activate.php');
	require_once('./src/validations.php');

	$info = $error = '';

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
			if(!isset($_FILES['file']) ) {
				$error = 'Error occured, try again';
			}
			$uploads_dir = './uploads/images/';
			$name = basename($_FILES['file']['name']);
			move_uploaded_file($_FILES['file']['tmp_name'], $uploads_dir.$name);
			$qparam = http_build_query(array('info' => 'uploaded'));
			header('Location: upload.php?' . $qparam);
		}
		if ($error)
			echo get_template('upload.php', array(
				'title' => 'New post',
				'info' => $info,
				'error' => $error,
			));

	}

	if (is_get_request()) {
		if (isset($_GET['info'])) {
			if ($_GET['info'] === 'uploaded');
				$info = "Uploaded successfully!";
		}
		echo get_template('upload.php', array(
			'title' => 'New post',
			'info' => $info,
			'error' => $error,
		));
	}
?>