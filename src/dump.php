<?php
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
