<?php
include_once('../conexion.php');
class Notificacion{
    private $sucursal_nit;
    private $nombre;
    private $mensaje;
    private $created_at;
    private $updated_at;
    private $logico;

    function Notificacion(){
        $this->sucursal_nit ="";
        $this->nombre ="";
        $this->mensaje ="";
        $this->created_at ="";
        $this->updated_at ="";
        $this->logico ="";
    }

    // SETTERS

    function setSucursal_nit($sucursal_nit){
        $this->sucursal_nit = $sucursal_nit;        
    }
    function setNombre($nombre){
        $this->nombre = $nombre;        
    }
    function setMensaje($mensaje){
        $this->mensaje = $mensaje;        
    }
    function setCreated_at($created_at){
        $this->created_at = $created_at;
    }
    function setUpdated_at($updated_at){
        $this->updated_at = $updated_at;
    }
    function setLogico($logico){
        $this->logico = $logico;
    }

    // GETTERS

    function getSucursal_nit(){
        return $this->sucursal_nit;
    }
    function getNombre(){
        return $this->nombre;
    }
    function getMensaje(){
        return $this->mensaje;
    }
    function getCreated_at(){
        return $this->created_at;
    }
    function getUpdated_at(){
        return  $this->updated_at;
    }
    function getLogico(){
        return $this->logico;
    }

    // FUNCION OBTENER INSCRIPCIÓNES
    function obtenerNotificaciones(){
        $conectar = new ConexionPDO();

        $query = "SELECT id_notificacion, sucursal_nit, nombre, mensaje, created_at, updated_at, logico FROM notificacion;";
        $consulta = $conectar->getConexion()->prepare($query);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($resultado);
    }

    function guardarNotificacion(){
        $query = 'INSERT INTO notificacion (sucursal_nit, nombre, mensaje) values (:sucursal_nit, :nombre, :mensaje);';
        try {
            $conectar = new ConexionPDO();
            
            $consulta = $conectar->getConexion()->prepare($query);
            $consulta->bindParam(':sucursal_nit',$_POST['sucursal_nit'],PDO::PARAM_INT);
            $consulta->bindParam(':nombre',$_POST['nombre'],PDO::PARAM_STR);
            $consulta->bindParam(':mensaje',$_POST['mensaje'],PDO::PARAM_STR);
            $consulta->execute(); 
            
            $msg = array('data'=> $conectar->getConexion()->lastInsertId());
            echo "NOTIFICACIÓN AÑADIDA CORRECTAMENTE, ID:" . json_encode($msg);
            }

        catch(PDOException $error){
            $msg = array('msg' => "ERROR AL EJECUTAR INSERT");  
            echo json_encode($msg);
        }
    }



    //FUNCION PARA MODIFICAR UNA NOTIFICACIÓN
    function actualizarNotificacion(){
        $query = 'UPDATE notificacion set sucursal_nit=:sucursal_nit, nombre=:nombre, mensaje=:mensaje, created_at=:created_at, updated_at=:updated_at, logico=:logico WHERE id_notificacion=:id_notificacion;';
        try {
            $conectar = new ConexionPDO();

            $consulta = $conectar->getConexion()->prepare($query);          
            $consulta->bindParam(':sucursal_nit',$_POST['sucursal_nit'],PDO::PARAM_INT);
            $consulta->bindParam(':nombre',$_POST['nombre'],PDO::PARAM_STR);
            $consulta->bindParam(':mensaje',$_POST['mensaje'],PDO::PARAM_STR);
            $consulta->bindParam (":created_at", $_POST['ceated_at'], PDO::PARAM_STR);
            $consulta->bindParam (":updated_at", $_POST['updated_at'], PDO::PARAM_STR);
            $consulta->bindParam(':logico',$_POST['logico'],PDO::PARAM_INT);
            $consulta->bindParam(':id_notificacion',$_GET['id_notificacion'],PDO::PARAM_INT);  
            // var_dump($consulta);
            $consulta->execute();
            
            $mensaje = array('data' => "Registro actualizado correctamente");
            echo json_encode($mensaje);

        }
        catch(PDOException $error){
            $mensaje = array('mensaje' => "Error al ejecutar UPDATE");
            echo json_encode($mensaje);
        }
    }

        //FUNCION PARA ACTUALIZAR UN CAMPO DE UNA NOTIFICACIÓN
        function actualizarCampoNotificacion(){
            $setvalues='';
            foreach($_GET as $elem => $valor){
                if($elem!='id_notificacion'){
                    $setvalues=$setvalues .''. $elem . '="' . $valor. '"';
                }
            }
            $query = 'UPDATE notificacion set '. $setvalues .' WHERE id_notificacion=:id_notificacion;';
            echo $query;
            try {
                $conectar = new ConexionPDO();
    
                $consulta = $conectar->getConexion()->prepare($query);          
                $consulta->bindParam(':id_notificacion',$_GET['id_notificacion'],PDO::PARAM_INT);  
                // var_dump($consulta);
                $consulta->execute();
                
                $mensaje = array('data' => "Registro actualizado con PATCH");
                echo json_encode($mensaje);
    
            }
            catch(PDOException $error){
                $mensaje = array('mensaje' => "Error al ejecutar PATCH");
                echo json_encode($mensaje);
            }
        }
}
$n = new Notificacion();