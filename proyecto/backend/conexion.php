<?php
include_once('/xampp/htdocs/proyecto/backend/config/parametros.php');
class ConexionPDO{
    private $conexion;
    function ConexionPDO(){
        $cadena = HOSTGESTOR . ':host=' . HOSTLOCALHOST . ';dbname=' . HOSTDB . ';port=' . HOSTPORT;
        try{
            $this->conexion= new PDO($cadena, HOSTUSER, HOSTPASS);
        }
        catch(PDOException $error){
            $mensaje = array('mensaje' => "Error al conectarse");
            echo json_encode($mensaje);
        }
    }
    
    function getConexion(){
        return $this->conexion;
    }
}

