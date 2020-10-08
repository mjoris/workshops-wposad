<?php

	/**
	 * Redirects to the error handling page
	 * @param string $type
	 * @return void
	 */
	function showDbError($type, $msg) {
		file_put_contents(__DIR__ . '/error_log_mysql', PHP_EOL . (new DateTime())->format('Y-m-d H:i:s') . ' : ' . $msg, FILE_APPEND);
		header('location: error.php?type=db&detail=' . $type);
		exit();
	}

	// Include config
	require_once 'config.php';

	// Make Connection
	try {
		$db = new PDO('mysql:host=' . DB_HOST .';dbname=' . DB_NAME_FF . ';charset=utf8mb4', DB_USER, DB_PASS);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	} catch (PDOException $e) {
		showDbError('connect', $e->getMessage());
	}

	// Get ID from URL
	$id = isset($_GET['id']) ? $_GET['id'] : '0';

	// Get collection from DB
	$stmt = $db->prepare('SELECT * FROM collections WHERE id = :id');
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();

	// Handle result here ....
	echo('Nothing to see here, check the source');

//EOF