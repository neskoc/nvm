<nav class="navbar container topBottomBordersIn">
    <a href="hem.php" class='<?= $uriFile == "hem.php" ? "selected" : null ?>'>Hem</a>
    <a href="vaegar.php" class='<?= $uriFile == "vaegar.php" ? "selected" : null ?>'>Vägar</a>
    <a href="artiklar.php" class='<?= $uriFile == "artiklar.php" ? "selected" : null ?>'>Artiklar</a>
    <a href="galleri.php" class='<?= $uriFile == "galleri.php" ? "selected" : null ?>'>Galleri</a>
    <a href="about.php" class='<?= $uriFile == "about.php" ? "selected" : null ?>'>Om</a>
    <a href="search.php" class='<?= $uriFile == "search.php" ? "selected" : null ?>'>Sök</a>
    <?php if ($_SESSION['logedin'] ?? false) : ?>
        <a href="admin.php" class='<?= $uriFile == "admin.php" ? "selected" : null ?>'>Admin</a>
        <a href="logout.php" class='<?= preg_match("/^logout.php/", $uriFile) ? "selected" : null ?>'>Logga ut</a>
    <?php else : ?>
        <a href="login.php" class='<?= preg_match("/^login.php/", $uriFile) ? "selected" : null ?>'>Admin</a>
    <?php endif; ?>
</nav>