<?php
session_start();

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