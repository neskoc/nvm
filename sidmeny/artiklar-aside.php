<div class="wrap-main">

    <?php
    require __DIR__ . "/aside-menu.php";
    if (isset($_GET['page'])) {
        $dsn = $databases[$_SESSION['database']];
        $db = connectToDatabase($dsn);
        $content = getPhpContentFromDB($db, 'Article', $_GET['page']);
    } else {
        $content = getPhpContentFromDB($db, 'Article', 6, false);
    }
    ?>
    <main class="aside-class">
        <article>
            <?= $content ?>
        </article>
    </main>
</div>
