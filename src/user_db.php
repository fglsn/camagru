<?php

function find_user_by_username($dbc, $username) {
	$sql = 'select user_id, username, email, password, notifications, active
			from users
			where username=:username';
	$stmt = $dbc->prepare($sql);
	$stmt->execute(array('username' => $username));
	return $stmt->fetch();
}

function find_user_by_id($dbc, $user_id) {
	$sql = 'select user_id, username, email, password, active
			from users
			where user_id=:user_id';
	$stmt = $dbc->prepare($sql);
	$stmt->execute(array('user_id' => $user_id));
	return $stmt->fetch();
}

function find_user_by_activation($dbc, $activation_code) {
	$sql = 'select user_id, active, activation_code
			from users
			where activation_code=:activation_code';
	$stmt = $dbc->prepare($sql);
	$stmt->execute(array('activation_code' => $activation_code));
	return $stmt->fetch();
}

function find_user_by_email($dbc, $email) {
	$sql = 'select user_id, username, email, password, active
			from users
			where email=:email';
	$stmt = $dbc->prepare($sql);
	$stmt->execute(array('email' => $email));
	return $stmt->fetch();
}

function find_username_by_id($dbc, $user_id) {
	$sql = 'select username from users where user_id=:user_id';
	$stmt = $dbc->prepare($sql);
	$stmt->execute(array('user_id' => $user_id));
	return $stmt->fetch();
}

function check_notifications_status($dbc, $user_id) {
	$sql = 'select email, notifications from users
			where user_id = :user_id';
	$stmt = $dbc->prepare($sql);
	$stmt->execute(array('user_id' => $user_id));
	return $stmt->fetch();
}

function delete_user($dbc, $user_id) {
	$sql = 'delete from users where user_id=:user_id';
	$stmt = $dbc->prepare($sql);
	return $stmt->execute(array('user_id' => $user_id));
}

?>