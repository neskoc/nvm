<?php
require __DIR__ . "/incl/multipage.php";

// Get what subpage to show, defaults to index
$pageReference = $_GET["page"] ?? "index";
$pageReference = $pageReference == '' ? 'index' : $pageReference;
//var_dump($pageReference);

// Get the filename of this multipage, exkluding the file suffix of .php
$base = basename(__FILE__, ".php");

$dsn = $databases[$_SESSION['database']];
$db = connectToDatabase($dsn);
$tableName = 'Article';
$subpages = getPagesFromTable($db, 'Article');
// Create the collection of valid sub pages.
$pages = [];
foreach ($subpages as $subpage) {
    $pages[] = [
        'title' => $subpage['title'],
        'name' => $subpage['name'],
        ];
}
// Get the current page from the $pages collection, if it matches
$page = $pages[$pageReference] ?? null;

// Base title for all pages and add title from selected multipage
// $title = $page["title"] ?? "404";
$title = "Artiklar";

// Render the page
require __DIR__ . "/incl/header.php";
require __DIR__ . "/sidmeny/artiklar-aside.php";
require __DIR__ . "/incl/footer.php";
