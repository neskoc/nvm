<?php
// Include the configuration file
require_once "config.php";

// Include essential functions
require_once "src/functions.php";

// Get the filename of this multipage, exkluding the file suffix of .php
// $base = basename(__FILE__, ".php");
$uriFile = basename($_SERVER["REQUEST_URI"]);
$uriFile_without_query = parse_url($uriFile, PHP_URL_PATH);
$uriBasename = basename($uriFile_without_query, '.php');
// Create the collection of valid sub pages.


/*
// debug code
echo '<div class="debug">';
echo 'uriFile: ' . $uriFile . '<br>';
echo 'url_path: ' . $uriFile_without_query . '<br>';
echo 'uriBasename: ' . $uriBasename . '<br>';
echo 'pageReference: ' . $pageReference . '<br>';
echo 'page: ';
print_r($jettyPages);
echo '</div>';
*/
