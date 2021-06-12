<?php
header('Content-type: application/json');
include_once('../models/Usuario.php');
include_once('../config/parametros.php');
$u = new Usuario();
switch($_SERVER["REQUEST_METHOD"]){
    case 'GET':
        $u->obtenerUsuario();
        break;
    
    case 'POST':
        $v = file_get_contents('php://input');
        $_POST = json_decode($v, true);
        var_dump($_POST);
        $u->insertarUsuario();
        break;

    case 'PUT':
        $v = file_get_contents('php://input');
        $_POST = json_decode($v, true);
        if(!isset($_GET["ci"])){
            $mensaje = array('mensaje'=>"Falta enviar el CI mediante la Url");
            echo json_encode($mensaje);
        }else{
            $u->actualizarUsuario();
        }
        break;
    

    default:
    $msg = array("msg"=>"Metodo no valido.");
    echo json_encode($msg);
}