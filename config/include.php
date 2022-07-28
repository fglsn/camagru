<?php
session_start();

function error_handler(int $errno, string $errmsg, string $file, int $line) {
	debug_to_console($errno . ' occured on line ' . $line . ' with message ' . $errmsg . ' in ' . $file);
	header('Location: error.php');
	die();
}

function exception_handler($exception) {
	debug_to_console($exception);
	header('Location: error.php');
	die();
}

set_error_handler('error_handler');
set_exception_handler('exception_handler');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/setup.php');	
require_once(__DIR__ . '/template.php');
require_once(__DIR__ . '/../src/web-helpers.php');

date_default_timezone_set('Europe/Helsinki');

$root_url = 'http://localhost:8080/camagru';
$sender_email = 'no-reply@camagru.com';

?>