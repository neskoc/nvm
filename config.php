<?php
/**
 * Configuration file with common settings.
 */
error_reporting(-1); // Report all type of errors
ini_set("display_errors", 1); // Display all errors

// Start the named session,
// the name is based on the path to this file.
$name = preg_replace("/[^a-z\d]/i", "", __DIR__);
session_name($name);
session_start();

$session_initial_counter = 10;

$databases = [];

// Create DSN's for the databases using their filenames

$fileName = __DIR__ . "/db/nvm.sqlite";
$dsn_nvm = "sqlite:$fileName";
$_SESSION['database'] = 'nvm';

$databases['nvm'] = $dsn_nvm;

$fileName = __DIR__ . "/db/credentials.sqlite";
$dsn_credentials = "sqlite:$fileName";
