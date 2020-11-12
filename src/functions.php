<?php
/**
 * Definitions of commonly used functions.
 */


if (!function_exists('array_key_last')) {
    function array_key_last(array $array)
    {
        return key(array_slice($array, -1, 1, true)) ?? null;
    }
}


if (!function_exists('array_key_first')) {
    function array_key_first(array $arr)
    {
        foreach (array_keys($arr) as $key) {
            return $key;
        }
        return null;
    }
}


/**
 *  Function takes one argument, which is the array itself
 *  and that array will be printed out
 *    run it as:
 *    dump($_SERVER);
 * @author    Mikael Roos, me@mikaelroos.se
 * @link      https://github.com/mosbth/csource
 */
function dump($array)
{
    echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}


/**
 *  The funktion which returns the link to the current web page
 *  run it as:
 *  echo getCurrentUrl();
 *
 * @author    Mikael Roos, me@mikaelroos.se
 * @link      https://github.com/mosbth/csource
 */
function getCurrentUrl()
{
    $url = "http";
    $url .= (@$_SERVER["HTTPS"] == "on") ? 's' : '';
    $url .= "://";
    $serverPort = ($_SERVER["SERVER_PORT"] == "80") ? '' :
        (($_SERVER["SERVER_PORT"] == 443 && @$_SERVER["HTTPS"] == "on") ? '' : ":{$_SERVER['SERVER_PORT']}");
    $url .= $_SERVER["SERVER_NAME"] . $serverPort . htmlspecialchars($_SERVER["REQUEST_URI"]);
    return $url;
}


/**
 * Destroy a session, the session must be started.
 *
 * @return void
 */
function sessionDestroy()
{
    // Unset all of the session variables.
    $_SESSION = [];

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
}


/**
 * Open the database file and catch the exception if it fails.
 *
 * @param string $dsn
 * @return PDO $db
 */
function connectToDatabase(string $dsn)
{
    try {
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Failed to connect to the database using DSN:<br>$dsn<br>";
        throw $e;
    }
    return $db;
}


/**
 * Fetch a table (if given return range only),
 * mark it as a html table, put in the string and return it
 *
 * @param PDO $db
 * @param string $tableName
 * @param int $startPage
 * @param int $maxHits
 * @param string|null $filter
 * @param string|null $link
 * @param int $keyColumn
 * @return string $table
 */
function fetchTableFromDB(
    PDO $db,
    string $tableName,
    int $startPage = 0,
    int $maxHits = 0,
    string $filter = null,
    string $link = null,
    int $keyColumn = 0
) {
    // Prepare the SQL statement
    $sql = "SELECT * FROM $tableName $filter LIMIT $startPage * $maxHits, $maxHits";
    // echo 'SQL:' . $sql;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $colcount = $stmt->columnCount();

    // Get the results as an array with column names as array keys
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the array and gather the data into table rows
    $table = '<table><tr>';
    $columnNames = [];
    for ($cnt = 0; $cnt < $colcount; $cnt++) {
        $columnNames[] = $stmt->getColumnMeta($cnt)['name'];
        $table .= "<th> {$columnNames[$cnt]} </th>";
    }
    $table .= '</tr>';
    foreach ($res as $row) {
        $table .= '<tr>';
        for ($cnt = 0; $cnt < $colcount; $cnt++) {
            if ($link != null && $cnt == $keyColumn) {
                $htmlRow = "<td><div class='height'><a href='{$link}&key={$row[$columnNames[$cnt]]}'>"
                    . $row[$columnNames[$cnt]] . '</a></div></td>';
                $table .= $htmlRow;
            } else {
                $table .= "<td><div class='height'>{$row[$columnNames[$cnt]]}</div></td>";
            }
        }
        $table .= '</tr>';
    }
    $table .= '</table>';
    return $table;
}


/**
 * Fetch a table, mark it as a html table, put in the string and return it
 *
 * @param PDO $db
 * @param $tableName
 * @param $key
 * @param int $keyColumn
 * @return string $table
 */
function fetchRowFromDB(PDO $db, string $tableName, $key, $keyColumn)
{
    // Prepare the SQL statement
    $sql = "SELECT * FROM {$tableName} WHERE {$keyColumn} = {$key}";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $colcount = $stmt->columnCount();

    // Get the results as an array with column names as array keys
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the array and gather the data into table rows
    $table = '<table><tr>';
    $columnNames = [];
    for ($cnt = 0; $cnt < $colcount; $cnt++) {
        $columnNames[] = $stmt->getColumnMeta($cnt)['name'];
        $table .= "<th> {$columnNames[$cnt]} </th>";
    }
    $table .= '</tr>';
    foreach ($res as $row) {
        $table .= '<tr>';
        for ($cnt = 0; $cnt < $colcount; $cnt++) {
            $table .= "<td class='width'> {$row[$columnNames[$cnt]]} </td>";
        }
        $table .= '</tr>';
    }
    $table .= '</table>';
    return $table;
}


/**
 * Fetch a table, mark it as a html table, put in the string and return it
 *
 * @param $db
 * @param string $tableName
 * @return array $columnNames
 */
function fetchColumnNames(PDO $db, string $tableName)
{
    // Prepare the SQL statement
    $sql = "SELECT * FROM $tableName LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return array_keys($row);
}


/**
 * Fetch a row with a given key, put it in the array
 *
 * @param PDO $db
 * @param string $tableName
 * @param $key
 * @param string $keyColumn
 * @return array $rowAsArray
 */
function fetchRowFromDBasArray(
    PDO $db,
    string $tableName,
    int $key,
    string $keyColumn
) {
    $columnNames = fetchColumnNames($db, $tableName);
    if (in_array("{$tableName}Id", $columnNames)) {
        $keyColumn =  $tableName . 'Id';
    }
    // Prepare the SQL statement
    $sql = "SELECT * FROM {$tableName} WHERE {$keyColumn} = {$key} LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $colcount = $stmt->columnCount();

    // Get the results as an array with column names as array keys
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $rowAsArray = [];
    foreach ($res as $row) {
        for ($cnt = 0; $cnt < $colcount; $cnt++) {
            $rowAsArray[$columnNames[$cnt]] = $row[$columnNames[$cnt]];
        }
    }
    /*
    dump($rowAsArray);
    exit();
    */
    return $rowAsArray;
}


/**
 * Fetch a row with a given key, put it in the list of input text html-elements
 * and make elements readonly if param $readOnly == true
 * Key-column is always readonly.
 *
 * @param array $row
 * @param string $dbkeyColumn
 * @param array $notNullColumnNames
 * @param bool $readOnly
 * @param bool $empty
 * @return string $rowAsHTMLCode
 */
function convertDBrowToHtmlInputElements(
    array $row,
    string $dbkeyColumn,
    array $notNullColumnNames,
    bool $readOnly = false,
    bool $empty = false
) {
    $rowAsHTMLCode = '';
    $inputElementPart1 = '<label for="$id">$label</label><br>';
    $inputElementPart2 = '<textarea rows="3" id="$id" name="$id" $readOnly $required>$value</textarea><br>';
    $inputElement = $inputElementPart1 . $inputElementPart2;
    foreach ($row as $key => $value) {
        $readOnlyString = '';
        $requiredString = '';
        if ($readOnly or $key == $dbkeyColumn) {
            $readOnlyString = 'readonly';
            $label = "$key: (readonly)";
        } elseif (is_numeric(array_search($key, $notNullColumnNames))) {
            $requiredString = 'required';
            $label = "$key: (required)";
        } else {
            $label = $key . ':';
        }
        if ($empty) {
            $value = '';
        }
        $replacement = array(
            '$id' => "$key",
            '$label' => "$label",
            '$value' => $value,
            '$readOnly' => $readOnlyString,
            '$required' => $requiredString
        );
        $rowAsHTMLCode .= strtr($inputElement, $replacement);
    }
    return $rowAsHTMLCode;
}


/**
 * Fetch all db table names
 *
 * @param string $dsn
 * @return array $tableAndColumnNames
 */
function fetchTableAndColumnNames(string $dsn)
{
    $db = connectToDatabase($dsn);
    // Prepare the SQL statement
    $sql = "SELECT tbl_name FROM sqlite_master WHERE type='table' ORDER BY tbl_name";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Get the results as an array with column names as array keys
    // $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tableAndColumnNames = [];
    foreach ($rows as $row) {
        $tableAndColumnNames[$row['tbl_name']] = fetchColumnNames($db, $row['tbl_name']);
    }
    // dump($tableNames);
    // dump(array_keys($tableNames));
    return $tableAndColumnNames;
}


/**
 * Fetch a table, mark it as a html table, put in the string and return it
 *
 * @param string $dsn
 * @return string $allTablesFromDB
 */
function fetchAllTablesFromDB(string $dsn)
{
    $allTablesFromDB = '';
    $tableNames = array_keys(fetchTableAndColumnNames($dsn));
    foreach ($tableNames as $tableName) {
        // Prepare the SQL statement
        $sql = "SELECT * FROM $tableName";
        $db = connectToDatabase($dsn);
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $allTablesFromDB .= fetchTableFromDB($db, $tableName, 0, -1);
    }
    return $allTablesFromDB;
}


/**
 * Construct checkbox list from the provided table names in an array
 *
 * @param array $values (list of checkboxes)
 * @param string $name (name for the checkbox group)
 * @param array $checked
 * @return array $chkBoxArray
 */
function constructCheckboxArray(
    array $values,
    string $name,
    array $checked = []
) {
    $startOfInputTmpl = "<input type='checkbox' name='{$name}[]' value='";
    $chkBoxArray = [];
    foreach ($values as $value) {
        $chkBoxArray[] = $startOfInputTmpl . $value . "' id='$value'"
            . (in_array($value, $checked) ? ' checked' : null)
            . "><label for='$value'>$value</label>";
    }
    return $chkBoxArray;
}


/**
 * Construct option list from the provided table names in an array
 *
 * @param array $values (list of options/tables)
 * @return string $optionList
 */
function constructOptionList(array $values)
{
    $optionList = '';
    $selectedDatabase = $_SESSION['database'] ?? false;
    $selectedTable = $_SESSION['table'] ?? false;
    foreach ($values as $value) {
        if ($value == $selectedTable or $value == $selectedDatabase) {
            $optionSelected = 'selected';
        } else {
            $optionSelected = '';
        }
        $optionList .= "<option value='$value' $optionSelected>$value</option>";
    }
    return $optionList;
}


/**
 * Construct html SELECT element the provided table names in an array
 *
 * @param array $values (list of options/tables)
 * @param string $name
 * @param string $msg
 * @return string $selectElement
 */
function construcSelectElement(array $values, string $name, string $msg)
{
    $selectElement = "<label for='$name'>$msg</label>";
    $selectElement .= "<select id='$name' name='$name'>";
    $selectElement .= constructOptionList($values);
    $selectElement .= "</select>";
    return $selectElement;
}


/**
 * Given columns and search string
 * produce filter string for WHERE-part of the SELECT command
 *
 * @param array $columnNames
 * @param string $search
 * @return string $filter
 */
function constructFilter(array $columnNames, string $search)
{
    $filter = ' WHERE ';
    $firstColumn = true;
    foreach ($columnNames as $columnName) {
        $filter .= (!$firstColumn ? ' OR ' : null)
            . "$columnName LIKE '$search'";
        $firstColumn = false;
    }
    return $filter;
}


/**
 * For future use
 *
 * @param string $search
 * @return string $search
 */
function dissectSearchString(string $search)
{
    return $search;
}


/**
 * Check user credentials with values in DB
 *
 * @param string $dsn
 * @param string $username
 * @param string $pass
 */
function checkUserCredentials(string $dsn, string $username, string $pass)
{
    $db = connectToDatabase($dsn);
    // Prepare the SQL statement
    $sql = "SELECT Username, Password FROM User";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        // echo "User: {$user['Username']}/$username {$user['Password']}/$passHash <br> ";
        if ($user['Username'] == $username && password_verify($pass, $user['Password'])) {
            $_SESSION['logedin'] = true;
            break;
        }
    }
    $_SESSION['logedin'] = $_SESSION['logedin'] ?? false;
    return null;
}


/**
 * Run SQL command by PDO
 *
 * @param PDO $db
 * @param string $sql
 * @return bool
 */
function executeSqlCommand(PDO $db, string $sql)
{
    $stmt = $db->prepare($sql);
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo "<p>Failed to run: <br>$sql<br> dumping details for debug.</p>";
        echo "<p>The error code: " . $stmt->errorCode();
        echo "<p>The error message:<pre>" . print_r($stmt->errorInfo(), true) . "</pre>";
        return false;
    }
    return true;
}


/**
 * Get number of rows in the table
 *
 * @param PDO $db
 * @param string $tableName
 * @return int | boolean // number of rows in the table
 */
function getNumberOfRowsInTable(PDO $db, string $tableName)
{
    if (isset($_SESSION['{$tableName}_count'])) {
        return $_SESSION['{$tableName}_count'];
    }
    $sql = "SELECT count(*) as cnt FROM $tableName";
    $stmt = $db->prepare($sql);
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo "<p>Failed to run: <br>$sql<br> dumping details for debug.</p>";
        echo "<p>The error code: " . $stmt->errorCode();
        echo "<p>The error message:<pre>" . print_r($stmt->errorInfo(), true) . "</pre>";
        return false;
    }
    $res = $stmt->fetch();
    return $res['cnt'];
}


/**
 * Roll back changes in the row
 *
 * $columnToRollback / $pkColumn = array
 * (
 *     [0] => ColumnName
 *     [1] => ColumnValue
 * )
 *
 * @param PDO $db
 * @param string $tableName
 * @param array $columnToRollback
 * @param array $pkColumn
 * @return bool|null
 */
function rollBackChange(
    PDO $db,
    string $tableName,
    array $columnToRollback,
    array $pkColumn
) {
    // Loop through the array and gather the data into table rows
    $sql = "UPDATE $tableName SET {$columnToRollback[0]} = '{$columnToRollback[1]}'";
    $sql .= " WHERE {$pkColumn[0]} = '{$pkColumn[1]}'";
    $stmt = $db->prepare($sql);
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo "<p>Failed to run: <br>$sql<br> dumping details for debug.</p>";
        echo "<p>The error code: " . $stmt->errorCode();
        echo "<p>The error message:<pre>" . print_r($stmt->errorInfo(), true) . "</pre>";
        return null;
    }
    return false;
}


/**
 * Try to update one column by writing null and check for exception
 *
 * @param PDO $db
 * @param string $tableName
 * @param array $columnNamesAndValues
 * @param string $testForNull
 * @param array $pkColumn
 * @return bool|null
 *
 * probeColumnForNull ($db, $tableName, $columnNamesAndValues, $columnName, $pkColumn)
 */
function probeColumnForNull(
    PDO $db,
    string $tableName,
    array $columnNamesAndValues,
    string $testForNull,
    array $pkColumn
) {
    // Loop through the array and gather the data into table rows
    $sql = "UPDATE $tableName SET ";
    $isFirst = true;
    foreach ($columnNamesAndValues as $key => $value) {
        if ($key != $pkColumn[1]) {
            if (!$isFirst) {
                $sql .= ', ';
            }
            if ($key != $testForNull) {
                $sql .= "$key = '$value'";
            } else {
                $sql .= "$key = null";
            }
            $isFirst = false;
        }
    }
    $sql .= " WHERE {$pkColumn[1]} = '{$columnNamesAndValues[$pkColumn[1]]}'";
    $stmt = $db->prepare($sql);
    // var_dump($res);
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        if ($stmt->errorCode() == 23000) {
            return true;
        }
        echo "<p>Failed to run: <br>$sql<br> dumping details for debug.</p>";
        echo "<p>The error code: " . $stmt->errorCode();
        echo "<p>The error message:<pre>" . print_r($stmt->errorInfo(), true) . "</pre>";
        return null;
    }
    return false;
}


/**
 * Fetch a table, mark it as a html table, put in the string and return it
 * $pkColumn = array
 * (
 *     [0] => ColumnNameAsIndex
 *     [1] => ColumnName
 * )
 *
 * @param PDO $db
 * @param string $tableName
 * @param array $pkColumn
 * @return array $notNullColumnNames
 */
function fetchNotNullColumnNames(PDO $db, string $tableName, array $pkColumn)
{
    $sql = "SELECT * FROM $tableName LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $columnNamesAndValues = [];
    foreach ($row as $columnName => $columnValue) {
        if ($columnValue != null) {
            $columnNamesAndValues[$columnName] = $columnValue;
        }
    }

    $notNullColumnNames = [];
    foreach ($columnNamesAndValues as $columnName => $columnValue) {
        if ($columnName != $pkColumn[1]) {
            $isNotNull = probeColumnForNull($db, $tableName, $columnNamesAndValues, $columnName, $pkColumn);
            if ($isNotNull) {
                array_push($notNullColumnNames, $columnName);
            }
        }
    }
    // dump($tableNames);
    // dump(array_keys($tableNames));
    return $notNullColumnNames;
}


/**
 * Get column which is pk for the table as array
 * $pkColumn = array
 * (
 *     [0] => ColumnNameAsIndex
 *     [1] => ColumnName
 * )
 *
 * @param string $tableName
 * @param array $columnNames
 * @return array $pkColumn
 */
function getPkColumn(string $tableName, array $columnNames)
{
    // test for existence of the "{$tableName}Id" column
    $pkColumnName = "{$tableName}Id";
    if (($pkColumnAsNumber = array_search($pkColumnName, $columnNames)) === false) {
        // if not found as tableNameId assume first column
        $pkColumnAsNumber = 0;
    }
    $pkColumn[0] = $pkColumnAsNumber;
    $pkColumn[1] = $columnNames[$pkColumnAsNumber];
    return $pkColumn;
}


/**
 * Get pages from DB table
 * $pages = Array
 * (
 *  Array
 *      (
 *      [0] => name
 *      [1] => title
 *      )
 * )
 *
 * @param PDO $db
 * @param string $tableName
 * @return array $pages
 */
function getPagesFromTable(PDO $db, string $tableName)
{
    // Prepare the SQL statement
    $sql = "SELECT name, title FROM $tableName";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $pages;
}


/**
 * Format given row as html
 * It is helpfunction for getPhpContentFromDB to prevent error
 * The function getPhpContentFromDB() has a Cyclomatic Complexity of 10.
 * The configured cyclomatic complexity threshold is 10
 *
 * @param array $row
 * @param string $previousItemLink
 * @param string $nextItemLink
 * @return string $pageContent
 */
function formatRowAsHtml(array $row, string $previousItemLink, string $nextItemLink) : string
{
    $img1Tag = '';
    if (!is_null($row["image1"])) {
        $img1Tag = <<<IMG
            <div class="content-center">
                {$row["gps"]}
                <figure>
                    <img src="img/500/{$row["image1"]}" alt="{$row["image1Alt"]}">
                    <figcaption>{$row["image1Text"]}</figcaption>
                </figure>
            </div>
        IMG;
    }
    $img2Tag = '';
    if (!is_null($row["image2"])) {
        $img2Tag = <<<IMG
            <figure>
                <img src="img/500/{$row["image2"]}" alt="{$row["image2Alt"]}">
                <figcaption>{$row["image2Text"]}</figcaption>
            </figure>
        IMG;
    }
    return <<<EOL
        <header class="grid">
            $previousItemLink
            <h1>{$row["title"]}</h1>
            $nextItemLink
        </header>
        $img1Tag
        {$row["data"]}
        $img2Tag
        <p class="author"><a href="artiklar.php?page=09"> Author: {$row["author"]}</a></p>
    EOL;
}


/**
 * Get page content from DB
 *
 * @param PDO $db
 * @param string $tableName
 * @param int $pageNr | str 'last'
 * @param bool $notSinglePage
 * @return string $pageContent
 */
function getPhpContentFromDB(PDO $db, string $tableName, int $pageNr, $notSinglePage = true) : string
{
    $previousItemLink = '<div></div>';
    $nextItemLink = '<div></div>';
    if ($notSinglePage) {
        $nrOfRows = getNumberOfRowsInTable($db, $tableName);
        if ($tableName == 'Article') {
            $linkBase = 'artiklar.php?page=';
        } else {
            $linkBase = 'vaegar.php?page=';
        }
        $aTag = '<a href="$linkBase$linkId">$Value</a>';
        if ($pageNr > 0) {
            $replacement['$linkId'] = $pageNr > 11 ? $pageNr - 1 : '0' . ($pageNr - 1);
            $replacement['$Value'] = 'Föregående';
            $replacement['$linkBase'] = $linkBase;
            $previousItemLink = strtr($aTag, $replacement);
        }
        if ($pageNr < $nrOfRows - 1) {
            $replacement['$linkId'] = $pageNr > 8 ? $pageNr + 1 : '0' . ($pageNr + 1);
            $replacement['$Value'] = 'Nästa';
            $replacement['$linkBase'] = $linkBase;
            $nextItemLink = strtr($aTag, $replacement);
        }
    }
    // Prepare the SQL statement
    $pageNr++;
    if ($tableName == 'Article') {
        $title = 'longTitle';
    } else {
        $title = 'title';
    }
    $sql = "SELECT $title as title, data, gps, author, image1, image1Alt, image1Text, image2, image2Alt, image2Text" .
        " FROM $tableName where {$tableName}Id == $pageNr LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return formatRowAsHtml($row, $previousItemLink, $nextItemLink);
}


/**
 * Get all object from DB as grid
 *
 * @param PDO $db
 * @param string $tableName
 * @return string $pageContent
 */
function getObjectsAsGrid(PDO $db, string $tableName) : string
{
    // Prepare the SQL statement
    $sql = "SELECT title, image1, image1Alt, image1Text FROM $tableName";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $pageContent = '<div class="objects-grid">';
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = 0;
    foreach ($rows as $row) {
        $count = $count < 10 ? '0' . $count : $count;
        $pageContent .= <<<DIV
            <div class="content-center">
                {$row["title"]}
                <figure>
                    <a href="?page=$count">
                        <img src="img/250/{$row["image1"]}" alt="{$row["image1Alt"]}">
                    </a>
                    <figcaption>{$row["image1Text"]}</figcaption>
                </figure>
            </div>
        DIV;
        $count++;
    }
    $pageContent .= '</div>';
    return $pageContent;
}
