<?php

/**
 * Redirects to the error handling page
 * @param string $type
 * @return void
 */
function showDbError(string $type): void
{
    // The referrerd page will show a proper error based on the $_GET parameters
    header('location: error.php?type=db&detail=' . $type);
    exit();
}

// Include config
require_once 'config.php';

// Make Connection
try {
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=does_not_exist;charset=utf8mb4', DB_USER, DB_PASS);
} catch (PDOException $e) {
    showDbError('connect');
}

echo 'Connected to the database';

// ... your query magic here

//EOF