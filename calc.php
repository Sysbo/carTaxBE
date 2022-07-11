<?php
error_reporting(-1);
ini_set( 'display_errors', 1 );

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once($class . '.php');
});
session_start();

use app\model\Vehicle;
$vehicle = new Vehicle();

function control_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$data = json_decode(file_get_contents("php://input"));


foreach ($data as $key => $d) {
    switch ($d->name) {
        case 'vehicleType':
            $vehicle->vehicleType = control_input($d->value);
            break;
        case 'region':
            $vehicle->region = control_input($d->value);
            break;
        case 'new':
            $vehicle->new = ("yes" == control_input($d->value)) ? true : false;
            break;
        case 'registration-date':
            $vehicle->setAge(htmlspecialchars($d->value));
            $vehicle->firstRegis = control_input($d->value);
            break;
        case 'fuel':
            $vehicle->fuel = control_input($d->value);
            break;
        case 'cm3':
            $vehicle->setCm3(control_input($d->value));
            break;
        case 'kw':
            $vehicle->kw = control_input($d->value);
            break;
        case 'co2':
            $vehicle->co2 = control_input($d->value);
            break;
        case 'mma':
            $vehicle->mma = control_input($d->value);
            break;
    }
}


require('views/components/taxResult.php');