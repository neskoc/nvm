<div class="wrap-main">

    <?php
    require __DIR__ . "/aside-menu.php";
    if (isset($_GET['page'])) {
        $dsn = $databases[$_SESSION['database']];
        $db = connectToDatabase($dsn);
        if ($_GET['page'] == -1) {
            $content = getObjectsAsGrid($db, 'Object');
        } else {
            $content = getPhpContentFromDB($db, 'Object', $_GET['page']);
        }
    } else {
        $content = getPhpContentFromDB($db, 'Article', 4, false);
    }
    ?>
    <main class="aside-class">
        <article>
            <?= $content ?>
        </article>
    </main>
</div>
