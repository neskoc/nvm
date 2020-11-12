<?php
include("incl/multipage.php");
if (isset($_SESSION['logedin'])) {
    unset($_SESSION['logedin']);
}
$_SESSION['notice'] = 'You are now logged out!';
// Redirect to a result page.
header("Location: login.php");
exit();
