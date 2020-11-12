<?php
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
