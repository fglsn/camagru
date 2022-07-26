<?php
require_once(__DIR__ . '/database.php');

function migrate($conn) {
	try {
		$sql = file_get_contents(__DIR__ . '/init_v1.sql');
		$conn->exec($sql);
		// echo 'Migrated successfully.';
	} catch(PDOException $e) {
		echo 'Migration failed: ' . $e->getMessage();
		die();
	}
}

function drop($conn) {
	try {
		$sql = file_get_contents(__DIR__ . '/drop_v1.sql');
		$conn->exec($sql);
	} catch (PDOException $e) {
		echo 'Something went wrong when dropping tables: ' . $e->getMessage();
		die();
	}
}

if ((isset($argc) && $argv[1] == 'setup') || !isset($argc)) {
	try {
		$conn = new PDO($DB_HOST, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		try {
			$max_migration = $conn->query('select max(mid) as mid from camagru_db.migrations')->fetch();
			if (!$max_migration) {
				migrate($conn);
			}
		} catch (PDOException $e) {
			migrate($conn);
		}
	} 
	catch(PDOException $e) {
		echo 'DB setup failed: ' . $e->getMessage();
		die();
	}
	$conn = null;

	$dbc = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
}


if (isset($argc)) {
	if ($argv[1] == 'drop') {
		try {
			$conn = new PDO($DB_HOST, $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			try {
				drop($conn);
			} catch (PDOException $e) {
				drop($conn);
			}
		} 
		catch(PDOException $e) {
			echo 'DB deletion failed: ' . $e->getMessage();
			die();
		}
		$conn = null;

		// $dbc = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	}
}


// https://www.php.net/manual/en/pdo.connections.php#pdo.connections

?>