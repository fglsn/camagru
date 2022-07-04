<?php
	require_once('./config/include.php');
	require_once('./src/modify_user.php');
	require_once('./src/validations.php');

	class SameUsernameException extends Exception {};

	$info = $err_username = '';
	$new_username = '';

	require_login('');

	if (is_post_request()) {
		//Change username
		if (isset($_POST['submit-new-username'])) {
			try {
				$new_username = validate_username($_POST['new-username']);
				if ($new_username == $_SESSION['username'])
					throw new SameUsernameException();
				update_username($dbc, $new_username);
				update_session_username($new_username);
				$qparam = http_build_query(array('info' => 'username_updated',
												'username' => $new_username));
				header('Location: settings.php?' . $qparam);
			}
			catch (UsernameExistsException $e) { //error thrown if username or email already in use, see unique indexes (sql)
				$err_username = "Username already exists. Try another username." . PHP_EOL;
			}
			catch (SameUsernameException $e) {
				$err_username = "Please provide new username.";
			}
			catch (ValidationException $e) {
				$err_username = $e->getMessage();
			}
			if ($err_username) {
				echo get_template('settings.php', array(
					'title' => 'Profile settings',
					'info' => $info,
					'err_username' => $err_username,
				));
			}
		}
	}

	if (is_get_request()) {
		if (isset($_GET['info'])) {
			if ($_GET['info'] === 'username_updated')
				$info = "Success! Your new username is now " . $_GET['username'];
		}
		echo get_template('settings.php', array(
			'title' => 'Profile settings',
			'info' => $info,
			'err_username' => $err_username,
		));
	}
?>