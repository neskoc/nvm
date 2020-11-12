<?php
include("incl/multipage.php");
$title = "Admin kommandon";
include("incl/header.php");
if (!isset($_GET['admin-action'])) {
    echo<<<HED
    <div class="wrap-main">
        <main>
            <article class="all-browsers">
                <header>
                    <h1>Admin actions</h1>
                    <p class="author">Updated <time datetime="2020-09-28 11:15:12">September the 28th 2020</time> by 007</p>
                </header>
                You can open this page only by been automatically sent from admin-page!
            </article>
        </main>
    </div>
    HED;
    include("incl/byline.php");
    include("incl/footer.php");
    exit();
} elseif ($_GET['admin-action'] == 'init') {
    $msg = 'DB has been restored!';
}
?>
<div class="wrap-main">
    <main>
        <article class="all-browsers">
            <header>
                <h1>Admin actions</h1>
                <p class="author">Updated <time datetime="2020-09-28 11:15:12">September the 28th 2020</time> by 007</p>
            </header>
            <section class="kmom">
                <h2><?= $msg ?></h2>
                Click on <a href="admin.php">admin</a> to proceed with db administration.
            </section>
        </article>
    </main>
</div>

<?php
include("incl/footer.php");
?>