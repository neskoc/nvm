<?php
include("incl/multipage.php");
$title = "Admin-sida";
if ($_GET['dbaction'] ?? false and $_GET['dbaction'] == 'create') {
    $_SESSION['dbaction'] = 'create';
    // Redirect to a dbrow-action.php page.
    header("Location: dbrow-action.php?action={$_GET['dbaction']}&table={$_GET['table']}&maxhits={$_GET['maxhits']}&startPage={$_GET['startPage']}");
    exit();
}
include("incl/header.php");
?>

<main>
    <article class="all-browsers">
        <header>
            <h2>ADMIN</h2>
        </header>
        <?php
        if (isset($_GET['database'])) {
            $_SESSION['database'] = $_GET['database'];
        }
        if (isset($_GET['table'])) {
            $_SESSION['table'] = $_GET['table'];
        }
        if (!isset($_SESSION['logedin']) or !isset($_SESSION['database'])) {
            if (!isset($_SESSION['logedin'])) {
                echo <<<LGI
                    <p>
                        Du behöver logga in först!
                        Klicka <a href="login.php">här</a> för att komma till inloggningssidan.
                    </p>
                    </article>
                </main>
                LGI;
            } elseif (!isset($_SESSION['database'])) {
                echo <<<DB
                <section class="kmom">
                    <h3>Tillgängliga databaser</h3>
                    <p>Välj en databas:</p>
                    <form>
                DB;
                $msg = 'Tillgängliga databaser:';
                echo construcSelectElement(array_keys($databases), 'database', $msg);
                echo<<<END
                    <input name="submit" type="submit" value="välj DB">
                </form></article></main>'
                END;
            }
            include("incl/byline.php");
            include("incl/footer.php");
            exit();
        }
        $maxhits = isset($_GET['maxhits']) ? $_GET['maxhits'] :
            (isset($_SESSION['maxhits']) ? $_SESSION['maxhits'] : 100);
        $_SESSION['maxhits'] = $maxhits;
        $startPage = isset($_GET['startPage']) ? $_GET['startPage'] :
            (isset($_SESSION['startPage']) ? $_SESSION['startPage'] : 0);
        $_SESSION['startPage'] = $startPage;
        $dbaction = isset($_GET['dbaction']) ? $_GET['dbaction'] :
            (isset($_SESSION['dbaction']) ? $_SESSION['dbaction'] : null);
        $_SESSION['dbaction'] = $dbaction;
        $dsn = $databases[$_SESSION['database']];
        // No search/SELECT filter
        $search = '%';
        ?>
        <section class="kmom">
            <h3>Site administration</h3>
            <hr>
            <form>
                <h4>Val av tabellen och funktionerna</h4>
                <p class="lined-box">
                    <?php
                    $tableAndColumnNames = fetchTableAndColumnNames($dsn);
                    $tableNames = array_keys($tableAndColumnNames);
                    $msg = '<strong>Välj en tabell</strong>';
                    echo construcSelectElement($tableNames, 'table', $msg);
                    ?>
                </p>
                <p class="lined-box">
                    <strong>Välj vad du vill göra med tabellen</strong>
                    <br>
                    <input type="radio" id="create" name="dbaction" value="create" required
                        <?= $dbaction == 'create' ? 'checked' : null ?>>
                    <label for="create">Lägg till en ny rad</label>
                    <input type="radio" id="update" name="dbaction" value="update"
                        <?= $dbaction == 'update' ? 'checked' : null ?>>
                    <label for="update">Uppdatera uppgifterna</label>
                    <input type="radio" id="delete" name="dbaction" value="delete"
                        <?= $dbaction == 'delete' ? 'checked' : null ?>>
                    <label for="delete">Ta bort raden</label>
                </p>
                <h4>Alternativ: Återställ databasen från backup</h4>
                <p class="lined-box">
                    Klicka på <a href="post-redirect.php?send=admin&action=init">återställ databasen</a> för att genomföra återställningen.
                    <br>
                    <span class="error">Varning!</span> Detta kommer resultera i att samtliga ändringar sedan senaste backupen kommer att försvinna!
                </p>
                <input name="submit" type="submit" value="Bekräfta">
                <?php
                // Execute the SQL statement
                $db = connectToDatabase($dsn);
                $tableNames[] = null;
                $filter = null;
                if (!empty($_SESSION['table'])) {
                    echo<<<TBL
                        <hr>
                        <h4>Steg 2 &mdash; Tabell: {$_SESSION['table']} - Radhantering</h4>
                        <p>Klicka på radens ID i den första kolumnen för att hantera den raden!</p>
                    TBL;
                    $link = "dbrow-action.php?action={$_SESSION['dbaction']}&table={$_SESSION['table']}&maxhits={$_SESSION['maxhits']}&startPage={$_SESSION['startPage']}";
                    $keyColumn = 0;
                    echo fetchTableFromDB($db, $_SESSION['table'], $startPage, $maxhits, $filter, $link, $keyColumn);
                } else {
                    echo "<p class='error'>Du behöver välja en tabell från listan ovan!";
                }
                ?>
        </section>
    </article>
</main>

<?php
include("incl/footer.php");
?>