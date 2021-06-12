<?php
header('Content-type: application/json');
include_once('../models/Cliente.php');
include_once('../config/parametros.php');
$c = new Cliente();
switch($_SERVER["REQUEST_METHOD"]){
    case 'GET':
        $c->obtenerCorreos();
        break; 
    default:
    $msg = array("msg"=>"Metodo no valido.");
    echo json_encode($msg);
}