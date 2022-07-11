<?php
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once($class . '.php');
});
session_start();

if (!isset($_SESSION["vehicles"])) {
    $_SESSION["vehicles"] = array();
}

$vehicle = file_get_contents("php://input");
$vehicle = json_decode($vehicle);

if(!empty($vehicle))
array_unshift($_SESSION["vehicles"], $vehicle);


require('views/components/savedVehicles.php');
