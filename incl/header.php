<!doctype html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href=<?= $_SESSION['custom_style'] ?? "css/style.css" ?>>
    <link rel='shortcut icon' href='img/favicon.ico' type="image/jpg"/>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=2.0;">
</head>

<body>
    <header class="site-header">
        <img src="img/vagmuseum_logga.jpg" alt="logo" />
        <?php include("incl/navbar.php") ?>
    </header>
