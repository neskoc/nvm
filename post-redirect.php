<?php
include("config.php");
include("src/functions.php");

/**
 * A processing page that does a redirect.
 */
if ($_POST["send"] ?? false) {
    if ($_POST["sendingpage"] == "login") {
        $userForm = htmlentities($_POST["user"] ?? null);
        $passForm = htmlentities($_POST["pass"] ?? null);
        checkUserCredentials($dsn_credentials, $userForm, $passForm);
        if (!($_SESSION["logedin"])) {
            $_SESSION['error_message'] = 'Wrong credentials! Try again.';
        }
        $url = "admin.php";
    }
}
if ($_GET["send"] ?? false) {
    if ($_GET["send"] == "admin") {
        if ($_GET['action'] == 'init') {
            $pattern = '/(.*)\.[^.]+$/';
            // preg_match($pattern, $_SESSION['database'], $db_striped);
            $db_path = __DIR__ . "/db/{$_SESSION['database']}";
            //echo "sqlite3 {$db_path}.sqlite <  {$db_path}.sql";
            //exit();
            exec("sqlite3 {$db_path}.sqlite <  {$db_path}.sqlite.sql");
            $url = "post-admin.php?admin-action=init";
        }
    }
}
$url =  $url ?? 'unknown-sender.php';
// Redirect to a result page.
header("Location: $url");
exit();
