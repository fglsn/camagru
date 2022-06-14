<?php
	require_once('./config/include.php');
	session_destroy();
	$qparam = http_build_query(array('info' => 'logout'));
	header('Location: login.php?' . $qparam);

	//small confirmation that user logged out
?>