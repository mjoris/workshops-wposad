<?php

	// Include config
	require_once 'config.php';

	// Make Connection
	try {
		$db = new PDO('mysql:host=' . DB_HOST .';dbname=does_not_exist;charset=utf8mb4', DB_USER, DB_PASS);
	} catch (PDOException $e) {
		exit('Could not connect to database server or access database');
	}

	echo 'Connected to the database';

	// ... your query magic here

//EOF