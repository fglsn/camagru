<?php

	function is_post_request(): bool {
		return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
	}

	function is_get_request(): bool {
		return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
	}

	function is_user_logged_in(): bool {
		return isset($_SESSION['user_id']);
	}

	function require_login($path): void {
		if (!is_user_logged_in()) {
			header('Location: login.php');
			exit;
		} 
		if (isset($path)) {
			header("Location: $path");
		}
	}

	// -- Sanitize input --
	function input_data($data) {  
		$data = trim($data);  
		$data = stripslashes($data);  
		$data = htmlspecialchars($data);  
		return $data;  
	}

?>