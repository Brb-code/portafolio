<?php
header('Content-type: application/json');
include_once('../models/Notificacion.php');
include_once('../models/Cliente.php');
include_once('../config/parametros.php');
$n = new Notificacion();
switch($_SERVER["REQUEST_METHOD"]){
    case 'GET':
            $n->obtenerNotificaciones();
        break;    

    case 'POST':
            $v = file_get_contents('php://input');
            $_POST = json_decode($v, true);
            var_dump($_POST);
            $n->guardarNotificacion();
        break;
        
    
    case 'PUT':
        $v = file_get_contents('php://input');
        $_POST = json_decode($v, true);
        if(!isset($_GET["id_notificacion"])){
            $mensaje = array('mensaje'=>"Falta enviar el id de la inscripción mediante la Url");
            echo json_encode($mensaje);
        }else{
            $n->actualizarNotificacion();
        }
        break;
    
    case 'PATCH':
        if(!isset($_GET["id_notificacion"])){
            $mensaje = array('mensaje'=>"Falta enviar el id de la inscripción mediante la Url");
            echo json_encode($mensaje);
        }
        else{
            $n->actualizarCampoNotificacion();
        }
        break;
        
    default:
    $msg = array("msg"=>"Metodo no valido.");
    echo json_encode($msg);
}