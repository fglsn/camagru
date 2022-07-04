<?php

	require_once (__DIR__ . '/../config/include.php');
	
	class UsernameExistsException extends Exception {};

	function update_username($dbc, $new_username) {
		try {
			$sql = 'update users
				set username=:new_username
				where user_id=:user_id';
			$stmt = $dbc->prepare($sql);
			return $stmt->execute(array('new_username' => $new_username,
										'user_id' => $_SESSION['user_id']));
		}
		catch (PDOException $e) {
			$err = $e->getMessage();
			if (strpos($err, "username_index"))
				throw new UsernameExistsException();
			else
				throw $e;
		}
	}

	function update_session_username($new_username) {
		$_SESSION['username'] = $new_username;
	}

?>