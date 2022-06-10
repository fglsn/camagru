<?php

function get_template($templatePath, array $vars = array()) {
	extract($vars);
	ob_start();
	require_once(__DIR__ . '/../templates/' . $templatePath);
	return ob_get_clean();
}

// https://stackoverflow.com/a/2173199
// https://stackoverflow.com/questions/36577020/php-failed-to-open-stream-no-such-file-or-directory/36577021#36577021

?>