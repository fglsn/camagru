<?php

	function is_post_request(): bool {
		return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
	}

	function is_get_request(): bool {
	return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}

?>