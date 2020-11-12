<?php
include("incl/multipage.php");
$title = "Login-sida";
include("incl/header.php");
?>
<div class="wrap-main">
    <main>
        <article class="all-browsers">
            <header>
                <h1>Inloggningssida för admin</h1>
            </header>
            <section class="kmom">
                <?php
                if ($_SESSION['error_message'] ?? false) {
                    echo '<p class="error"> Error: ' . $_SESSION['error_message'] . "</p>";
                    unset($_SESSION['error_message']);
                }
                if ($_SESSION['notice'] ?? false) {
                    echo '<p class="info">Notice: ' . $_SESSION['notice'] . '</p>';
                    unset($_SESSION['notice']);
                }
                ?>
                <form class="contact" method="post" action="post-redirect.php">
                    <fieldset>
                        <legend>Ange dina inloggningsuppgifter</legend>
                        <label for="user">Användarnamn: </label>
                        <br>
                        <input type="text" id="user" name="user" required>
                        <br>
                        <label for="pass">Lösenord: </label>
                        <br>
                        <input type="password" id="pass" name="pass" required>
                        <br>
                        <input type="hidden" name="sendingpage" value="login">
                        <input type="submit" name="send" value="Send">
                    </fieldset>
                </form>
            </section>
        </article>
    </main>
</div>

<?php
include("incl/footer.php");
?>