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

function pre_print($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function error($message, $exit = true, $code = 1)
{
    echo '<h1>[ERROR] ' . $message . '</h1>';

    if($exit)
        exit($code);
}
