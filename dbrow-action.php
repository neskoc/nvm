<?php
include("incl/multipage.php");
$title = "DB action page | htmlphp";
include("incl/header.php");
?>
<main>
    <article class="all-browsers">
        <header>
            <h2>Admin: DB kommandon</h2>
        </header>
        <?php
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
            } elseif (!isset($_GET['action'])) {
                echo <<<DBA
                <section class="kmom">
                    <h3>Saknas värdet för kommandot</h3>
                    <p>Kommando för raden saknas! Gå tillbaka till admin-sidan och välj ett db-kommando.</p>
                DBA;
            }
            include("incl/byline.php");
            include("incl/footer.php");
            exit();
        }
        $dsn = $databases[$_SESSION['database']];

        $db = connectToDatabase($dsn);
        // fetchNotNullColumnNames($db, $_GET['table']);
        $columnNames = fetchColumnNames($db, $_GET['table']);
        /*
         * $columnNames example
         * Array
         * (
         *     [0] => EmployeeId
         *     [1] => LastName
         * )
         */
        $pkColumn = getPkColumn($_GET['table'], $columnNames);
        $notNullColumnNames = fetchNotNullColumnNames($db, $_GET['table'], $pkColumn);
        /*
        dump($notNullColumnNames);
        exit();
        */
        $columnNamesCopy = $columnNames;
        if (isset($_GET['submit'])) {
            $pkColumn = $_GET['table'] . 'Id';
            if (($pkColumnAsNumber = array_search($pkColumn, $columnNames)) === false) {
                $pkColumnAsNumber = 0;
            }
            $pkColumnName = $columnNames[$pkColumnAsNumber];
            $pkColumnValue = $_GET[$pkColumnName];
            $success = false;
            if ($_GET['submit'] == 'Delete') {
                $sql = "DELETE FROM {$_GET['table']} WHERE $pkColumnName = '$pkColumnValue'";
                $success = executeSqlCommand($db, $sql);
                $postActionMessage =  'Den valda raden är nu borttagen från databasen!';
                if ($success) {
                    echo $postActionMessage;
                } else {
                    echo 'Något gick snett!';
                };
            } else {
                if (($pkColumnAsNumber = array_search($pkColumn, $columnNamesCopy)) !== false) {
                    unset($columnNamesCopy[$pkColumnAsNumber]);
                } else {
                    array_shift($columnNamesCopy);
                }
                $valueArrayIsEmpty = true;
                foreach ($columnNamesCopy as $columnName) {
                    if ($_GET[$columnName] != '') {
                        $valueArrayIsEmpty = false;
                        break;
                    }
                }
                if (!$valueArrayIsEmpty) {
                    $isFirst = true;
                    switch ($_GET['submit']) {
                        case 'Insert':
                            $values = null;
                            $columnNamesAsString = null;
                            foreach ($columnNamesCopy as $columnName) {
                                if (!$isFirst) {
                                    $values .= ', ';
                                    $columnNamesAsString .= ', ';
                                }
                                if ($_GET[$columnName] == '') {
                                    $values .= 'null';
                                } else {
                                    $values .= "'$_GET[$columnName]'";
                                }
                                $columnNamesAsString .= $columnName;
                                $isFirst = false;
                            }
                            $sql = "INSERT INTO {$_GET['table']} ($columnNamesAsString)"
                                . " VALUES ($values)";
                            $success = executeSqlCommand($db, $sql);
                            $postActionMessage =  'Den nya raden är nu sparad i databasen!';
                            break;
                        case 'Update':
                            $sql = "UPDATE {$_GET['table']} SET ";
                            foreach ($columnNamesCopy as $columnName) {
                                if (!$isFirst) {
                                    $sql .= ', ';
                                }
                                if ($_GET[$columnName] == '') {
                                    $_GET[$columnName] = null;
                                }
                                $sql .= "$columnName = '{$_GET[$columnName]}'";
                                $isFirst = false;
                            }
                            $sql .= " WHERE $pkColumnName = '$pkColumnValue'";
                            $success = executeSqlCommand($db, $sql);
                            $postActionMessage =  'Ändrade värden är nu sparade i databasen!';
                            break;
                    }
                    if ($success) {
                        echo $postActionMessage;
                    } else {
                        echo 'Något gick snett!';
                    };
                } else {
                    echo 'Nothing to do, all fields are empty!';
                }
            }
            include("incl/byline.php");
            include("incl/footer.php");
            exit();
        }
        $disableEdit = false;
        $empty = false;
        $msg = '';
        $legend = '';
        $submitValue = '';
        if ($_GET['action'] == 'update') {
            $disableEdit = false;
            $empty = false;
            $legend = 'Ändra (update) vald rad';
            $msg = 'Ändra värdena nedan och klicka på Update';
            $submitValue = 'Update';
        } elseif ($_GET['action'] == 'create') {
            $disableEdit = false;
            $empty = true;
            $legend = 'Lägg till (insert) ny rad';
            $msg = 'Mata in värdena för den nya raden';
            $submitValue = 'Insert';
        } elseif ($_GET['action'] == 'delete') {
            $disableEdit = true;
            $legend = 'Ta bort (delete) den valda raden';
            $msg = 'Den valda raden kommer att tas bort';
            $submitValue = 'Delete';
        } else {
            echo 'Okänt kommando!';
            die();
        }
        if (isset($_GET['key'])) {
            $dbrow = fetchRowFromDBasArray($db, $_GET['table'], $_GET['key'], 0);
        } else {
            foreach ($columnNames as $columnName) {
                $dbrow[$columnName] = '';
            }
        }
        if (in_array("{$_GET['table']}Id", $columnNames)) {
            $dbkeyColumn =  $_GET['table'] . 'Id';
        } else {
            $dbkeyColumn = array_key_first($dbrow);
        }
        ?>
        <section class="kmom">
            <h3>Sista steget &mdash; Radhantering</h3>
            <form>
                <fieldset>
                    <legend><?= $legend ?></legend>
                    <p class="lined-box">
                        <strong><?= $msg ?></strong>
                        <br>
                        <?= convertDBrowToHtmlInputElements($dbrow, $dbkeyColumn, $notNullColumnNames, $disableEdit, $empty) ?>
                        <br>
                    </p>
                    <input type="hidden" id="table" name="table" value="<?= $_GET['table'] ?>">
                    <input name="submit" type="submit" value="<?= $submitValue ?>">
                </fieldset>
            </form>
        </section>
    </article>
</main>
<?php
include("incl/footer.php");
?>