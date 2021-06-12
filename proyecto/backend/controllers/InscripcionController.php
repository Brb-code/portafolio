<?php
header('Content-type: application/json');
include_once('../models/Inscripcion.php');
include_once('../models/Cliente.php');
include_once('../config/parametros.php');
$i = new Inscripcion();
switch($_SERVER["REQUEST_METHOD"]){
    case 'GET':
        if(!isset($_GET["id_inscripcion"])){
            $i->obtenerInscritos();
        }else{
            $i->obtenerInscrito();
        }
        break;    
    case 'POST':
        if(!isset($_GET["cliente_id"])){
            $v = file_get_contents('php://input');
            $_POST = json_decode($v, true);
            var_dump($_POST);
            $i->registrarInscripcion();
        }else{
            $v = file_get_contents('php://input');
            $_POST = json_decode($v, true);
            var_dump($_POST);
            $i->añadirInscripcion();
        }
        break;
    case 'PUT':
        $v = file_get_contents('php://input');
        $_POST = json_decode($v, true);
        if(!isset($_GET["id_inscripcion"])){
            $mensaje = array('mensaje'=>"Falta enviar el id de la inscripción mediante la Url");
            echo json_encode($mensaje);
        }else{
            $i->actualizarInscripcion();
        }
        break;

    case 'PATCH':
        if(!isset($_GET["id_inscripcion"])){
            $mensaje = array('mensaje'=>"Falta enviar el id de la inscripción mediante la Url");
            echo json_encode($mensaje);
        }
        //elseif(sizeof($_GET)!=2){
        //     $mensaje = array('mensaje'=>"Debe enviar el id y un campo");
        //     echo json_encode($mensaje);
        // }
        else{
            $i->actualizarCampoInscripcion();
        }
        break;
    default:
    $msg = array("msg"=>"Metodo no valido.");
    echo json_encode($msg);
}

