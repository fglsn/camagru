<?php

	class NoFileProvidedException extends Exception {};
	class TooBigFileException extends Exception {};
	class FileNotAllowedException extends Exception {};

	const MAX_SIZE  = 5 * 1024 * 1024; //  5MB

	const allowedTypes = [
		'image/png' => 'png',
		'image/jpeg' => 'jpg'
	];

	const UPLOAD_DIR_NAME = '/uploads/';
	const UPLOAD_DIR_LOCATION = __DIR__  . '/..' . UPLOAD_DIR_NAME;

	const TEMP_DIR_NAME = '/temp/';
	const TEMP_DIR_LOCATION = __DIR__ . '/..' . TEMP_DIR_NAME;

	const STICKER_COUNT = 8;

	function save_image($filepath, $sticker_ids) {
		$filesize = filesize($filepath);

		if ($filesize == 0)
			throw new NoFileProvidedException();
		if ($filesize > MAX_SIZE)
			throw new TooBigFileException();

		$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
		$filetype = finfo_file($fileinfo, $filepath);

		if(!in_array($filetype, array_keys(allowedTypes))) 
			throw new FileNotAllowedException();

		$extension = allowedTypes[$filetype];
		$filename = uniqid('img_') . '.' . $extension;

		$image_full_path = UPLOAD_DIR_LOCATION . $filename;
		$image_relative_path = UPLOAD_DIR_NAME . $filename;
		rename($filepath, $image_full_path);

		add_stickers($image_full_path, $extension, $sticker_ids);
		// unlink($filepath);

		return $image_relative_path;
	}

	function prepare_image($picture_url) {
		$img = base64_decode(preg_replace("/data:image\/jpeg;base64,/", '', $picture_url));
		$temp_filepath = TEMP_DIR_LOCATION . uniqid('webcam') . '.jpeg';
		file_put_contents($temp_filepath, $img);

		$image = imagecreatefromjpeg($temp_filepath);
		imageflip($image, IMG_FLIP_HORIZONTAL);

		imagejpeg($image, $temp_filepath, 100);
		return ($temp_filepath);
	}

	const sticker_dir = __DIR__ . '/../static/stickers/';

	function parse_sticker_ids($request) {
		$sticker_ids = array();
		for ($i = 1; $i <= STICKER_COUNT; $i++) {
			if (isset($request['stick'.$i]) && $request['stick'.$i] === 'on')
				array_push($sticker_ids, $i);
		}
		return $sticker_ids;
	}

	function add_stickers($image_full_path, $extension, $sticker_ids) {
		$sticker_count = count($sticker_ids);
		if (!$sticker_count) {
			return;
		}
		if (!strcmp('jpg', $extension))
			$image = imagecreatefromjpeg($image_full_path);
		else if(!strcmp('png', $extension))
			$image = imagecreatefrompng($image_full_path);
		else
			throw new FileNotAllowedException();
		$image = imagescale($image, 680);
		for ($i = 0; $i < count($sticker_ids); $i++) {
			if ($sticker_ids[$i] < 1 || $sticker_ids[$i] > STICKER_COUNT) {
				continue;
			}
			$sticker_path = sticker_dir . $sticker_ids[$i] . '.png';
			$sticker = imagecreatefrompng($sticker_path);
			$marge_right = 520 - ($i * 170);
			$marge_bottom = 0;
			$sx = imagesx($sticker);
			$sy = imagesy($sticker);
			imagecopy($image, $sticker, imagesx($image) - $sx - $marge_right, imagesy($image) - $sy - $marge_bottom, 0, 0, imagesx($sticker), imagesy($sticker));
		}
		imagepng($image, $image_full_path);
	}

?>