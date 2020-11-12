<?php
include("incl/multipage.php");
$title = "Söksida";
include("incl/header.php");
?>

<main>
    <article class="all-browsers">
        <header>
            <h2>Här kan du söka bland artiklar och vägar</h2>
        </header>
        <?php
        $search = isset($_GET['search']) ? $_GET['search'] : null;
        $maxhits = isset($_GET['maxhits']) ? $_GET['maxhits'] : 10;
        $startPage = isset($_GET['startPage']) ? $_GET['startPage'] : 0;
        ?>
        <section>
            <header>
                <h2>Sökparametrar</h2>
            </header>
            <form>
                <fieldset>
                    <legend>Mata in söksträngen och parametrarna</legend>
                    <label for="maxhits">Begränsa antalet träffar/sida (mellan 5 och 20) till:</label>
                    <input type="number" id="maxhits" name="maxhits" min="5" max="20" value="<?=$maxhits?>">
                    <br>
                    <label for="startPage">Välj en startsida (positivt heltal inklusive 0) till:</label>
                    <input type="number" id="startPage" name="startPage" min="0" value="<?=$startPage?>">
                    <br>
                    <input type="search" name="search" value="<?=$search?>"
                           placeholder="Mata in söksträngen, använd % som wildcard.">
                    <input name="submit" type="submit" value="Sök">
                    <br>
                    ... eller klicka på <a href="?showall=true">visa allt</a> för att se allt.
                    <p>
                        Välj tabell(er) som sökningen skall göras inom:
                        <br>
                        <?php
                        $tableAndColumnNames = fetchTableAndColumnNames($dsn_nvm);
                        $tableNames =
                            array_keys($tableAndColumnNames);
                        $nvm = isset($_GET['nvm']) ? $_GET['nvm'] : [];
                        $_SESSION['chkBoxArray'] =
                            constructCheckboxArray($tableNames, 'nvm', $nvm);
                        foreach ($_SESSION['chkBoxArray'] as $chkBox) {
                            echo $chkBox . ' ';
                        }
                        ?>
                    </p>
                </fieldset>
            </form>
            <?php
            if (isset($_GET['showall'])) {
                $tableNames[] = null;
                $filter = null;
                echo '</section><section class="kmom">';
                echo "<h3>Innehåll i samtliga tabeller utan begränsningar:</h3>";
                echo fetchAllTablesFromDB($dsn_nvm);
                echo '</section></article></main>';
                include("incl/footer.php");
                exit(0);
            }
            // Break script if empty $search
            if (is_null($search)) {
                if (isset($_GET['submit'])) {
                    echo "<p class='error'>Hittar inget, var snäll och ändra parametrarna.</p>";
                }
                echo '</section></article></main>';
                include("incl/footer.php");
                exit(0);
            }
            $search = dissectSearchString($search);
            $search = htmlspecialchars($search, ENT_QUOTES | ENT_HTML5);
            ?>
        </section>
        <header>
            <h2>Visar max <?= $maxhits ?> resultat per tabell</h2>
        </header>
        <?php
        // Execute the SQL statement
        $db = connectToDatabase($dsn_nvm);
        $tableNames[] = null;
        $filter = null;
        if (!empty($_GET['nvm'])) {
            foreach ($_GET['nvm'] as $tableName) {
                $filter = constructFilter($tableAndColumnNames[$tableName], $search);
                echo '<section class="kmom">';
                echo "<h3>Sökresultat för tabellen: $tableName</h3>";
                echo fetchTableFromDB($db, $tableName, $startPage, $maxhits, $filter);
                echo '</section>';
            }
        } else {
            echo "<p class='warning'>Du behöver välja (bocka för) åtminstone en tabell från listan!";
        }
        ?>
    </article>
</main>

<?php
include("incl/footer.php");
?>