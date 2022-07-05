<?php
	require_once('./config/include.php');
	require_once('./src/modify_user.php');
	require_once('./src/validations.php');

	class SameUsernameException extends Exception {};
	class OldEmailException extends Exception {};
	class SameEmailException extends Exception {};
	class EmptyFieldException extends Exception {};

	$info = $err_username = $err_old_email = $err_email = $err_password = $err_new_password = '';
	$new_username = $new_email = $old_email = '';

	require_login('');

	// todo: Send notifications when modification request completed
	if (is_post_request()) {

		// Change username
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
					'err_old_email' => $err_old_email,
					'err_email' => $err_email,
					'err_password' => $err_password,
					'err_new_password' => $err_new_password,
				));
			}
		}

		// Change email address
		if (isset($_POST['submit-new-email'])) {
			try {
				$old_email = validate_email($_POST['old-email']);
				$new_email = validate_email($_POST['new-email']);
				if ($old_email !== $_SESSION['email'])
					throw new OldEmailException();
				if ($new_email == $_SESSION['email'])
					throw new SameEmailException();
				update_email($dbc, $new_email);
				update_session_email($new_email);
				$qparam = http_build_query(array('info' => 'email_updated',
												'email' => $new_email));
				header('Location: settings.php?' . $qparam);
			}
			catch (EmailExistsException $e) {
				$err_email = "This email is already in use, please try again.";
			}
			catch (OldEmailException $e) {
				$err_old_email = "Please confirm with your current email address.";
			}
			catch (SameEmailException $e) {
				$err_email = "Same email address provided, please insert new one.";
			}
			catch (ValidationException $e) {
				$err_email = $e->getMessage();
			}
			if ($err_email || $err_old_email) {
				echo get_template('settings.php', array(
					'title' => 'Profile settings',
					'info' => $info,
					'err_username' => $err_username,
					'err_old_email' => $err_old_email,
					'err_email' => $err_email,
					'err_password' => $err_password,
					'err_new_password' => $err_new_password,
				));
			}
		}

		// Change password
		if (isset($_POST['sumbit-new-password'])) {
			try {
				if (!$_POST['old-password'])
					throw new EmptyFieldException();
				verify_current_password($dbc, $_POST['old-password']);
				validate_password($_POST['new-password']);
				validate_confirmation($_POST['new-password'], $_POST['repeat-password']);
				update_password($dbc, $_POST['new-password']);
				$qparam = http_build_query(array('info' => 'password_updated'));
				header('Location: settings.php?' . $qparam);
			} catch (ValidationException $e) {
				$err_new_password = $e->getMessage();
			} catch (WrongPasswordException $e) {
				$err_password = "Wrong password. Try again.";
			} catch (EmptyFieldException $e) {
				$err_password = "Please insert your current password.";
			} catch (GeneralErrorException $e) {
				$info = "Sorry, something went wrong. Please try again.";
			}

			if ($err_password || $err_new_password || $info) {
				echo get_template('settings.php', array(
					'title' => 'Profile settings',
					'info' => $info,
					'err_username' => $err_username,
					'err_old_email' => $err_old_email,
					'err_email' => $err_email,
					'err_password' => $err_password,
					'err_new_password' => $err_new_password,
				));
			}
		}
	}

	if (is_get_request()) {
		if (isset($_GET['info'])) {
			if ($_GET['info'] === 'username_updated')
				$info = "Success! Your new username is now " . $_GET['username'];
			if ($_GET['info'] === 'email_updated')
				$info = "Success! Your new email address is now " . $_GET['email'];
			if ($_GET['info'] === 'password_updated')
				$info = "Done! Your password was updated successfully.";
		}
		echo get_template('settings.php', array(
			'title' => 'Profile settings',
			'info' => $info,
			'err_username' => $err_username,
			'err_old_email' => $err_old_email,
			'err_email' => $err_email,
			'err_password' => $err_password,
			'err_new_password' => $err_new_password,
		));
	}
?>