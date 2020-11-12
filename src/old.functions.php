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
 * @return PDO::setAttribute()
 */
function connectToDatabase($dsn)
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
 * Fetch a table, mark it as a html table, put in the string and return it
 *
 * @param $db
 * @param $sql
 * @param null $link
 * @param int $keyColumn
 * @return string $table
 */
function fetchTableFromDB($db, $sql, $link = null, $keyColumn = 0)
{
    // Prepare the SQL statement
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
                $htmlRow = "<td><a href='{$link}&key={$row[$columnNames[$cnt]]}'>"
                    . $row[$columnNames[$cnt]] . '</a></td>';
                $table .= $htmlRow;
            } else {
                $table .= "<td> {$row[$columnNames[$cnt]]} </td>";
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
 * @param $db
 * @param $sql
 * @param null $link
 * @param int $keyColumn
 * @return string $table
 */
function fetchRowFromDB($db, $tableName, $key, $keyColumn)
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
            $table .= "<td> {$row[$columnNames[$cnt]]} </td>";
        }
        $table .= '</tr>';
    }
    $table .= '</table>';
    return $table;
}
