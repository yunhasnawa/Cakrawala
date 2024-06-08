<?php

// Show error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'Util.php';
require_once 'Config.php';
require_once 'Application.php';
require_once 'Controller.php';
require_once 'View.php';
require_once 'Model.php';
require_once 'orm/Factory.php';
require_once 'orm/Entity.php';

function pre_print($data = array(), $die = false): void
{
    $trace = debug_backtrace();
    $firstLevel = $trace[0];

    $caller = "Data printed by: <strong>{$firstLevel['file']}</strong> on line <strong>{$firstLevel['line']}</strong>";

    echo "<br/>$caller<br/>";
    echo '<pre>';
    if($data === null)
        echo 'Data is null.';
    elseif ($data === '')
        echo "Data is an empty string ('').";
    else
        print_r($data);
    echo '</pre><br/>';

    if($die)
        die;
}

function error($message, $exit = true, $code = 1): void
{
    $trace = debug_backtrace();
    $firstLevel = $trace[0];

    $caller = "[ERROR]: <strong>{$firstLevel['file']}</strong> on line <strong>{$firstLevel['line']}</strong>";
    echo "<br/>$caller<br/>";
    echo "<pre>$message</pre><br/>";

    if($exit)
        exit($code);
}
