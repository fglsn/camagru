<?php

	function is_post_request(): bool {
		return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
	}

	function is_get_request(): bool {
		return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
	}

	function is_user_logged_in(): bool {
		return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
	}

	function require_login($path): void {
		if (!is_user_logged_in() && $path === '') {
			$qparam = http_build_query(array('info' => 'login_required'));
			header('Location: login.php?' . $qparam);
			exit;
		} 
		if (isset($path) && !empty($path)) {
			header('Location: $path');
		}
	}

	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);
	
		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;
	
		$string = array(
			'y' => 'Y',
			'm' => 'M',
			'w' => 'W',
			'd' => 'D',
			'h' => 'H',
			'i' => 'MIN',
			's' => 'SEC',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . $v . ($diff->$k > 1 ? '' : '');
			} else {
				unset($string[$k]);
			}
		}
	
		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' AGO' : 'JUST NOW';
	}

	// -- Sanitize input --
	function input_data($data) {  
		$data = trim($data);  
		$data = stripslashes($data);  
		$data = htmlspecialchars($data);  
		return $data;  
	}

	function debug_to_console($data) {
		$output = $data;
		if (is_array($output))
			$output = implode(',', $output);
		echo "<script>console.log('Debug output: ' . $output . '' );</script>";
	}

?>