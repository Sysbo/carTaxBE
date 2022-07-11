<?php
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once($class . '.php');
});

error_reporting(-1);
ini_set( 'display_errors', 1 );

session_start();

require('views/taxCalc.php');