<?php

	function posts_total($dbc) {
		$sql = 'select count(*) from posts';
		$stmt = $dbc->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetch();
		return $res[0];
	}

?>