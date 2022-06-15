<?php

	function is_post_request(): bool {
		return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
	}

	function is_get_request(): bool {
	return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}

	// -- Sanitize input --
	function input_data($data) {  
		$data = trim($data);  
		$data = stripslashes($data);  
		$data = htmlspecialchars($data);  
		return $data;  
	}

?>