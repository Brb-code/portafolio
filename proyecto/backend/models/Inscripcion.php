<?php
include_once('../conexion.php');
class Inscripcion{
    private $cliente_id;
    private $disciplina_id;
    private $sucursal_nit;
    private $fecha_inicio;
    private $fecha_fin;
    private $created_at;
    private $updated_at;
    private $logico;

    function Inscripcion(){
        $this->cliente_id ="";
        $this->disciplina_id ="";
        $this->sucursal_nit ="";
        $this->fecha_inicio ="";
        $this->fecha_fin ="";
        $this->created_at ="";
        $this->updated_at ="";
        $this->logico ="";
    }

    // SETTERS

    function setCliente_id($cliente_id){
        $this->cliente_id = $cliente_id;
    }
    function setDisciplina_id($disciplina_id){
        $this->disciplina_id = $disciplina_id;
    }
    function setSucursal_nit($sucursal_nit){
        $this->sucursal_nit = $sucursal_nit;
    }
    function setFecha_inicio($fecha_inicio){
        $this->fecha_inicio = $fecha_inicio;
    }
    function setFecha_fin($fecha_fin){
        $this->fecha_fin = $fecha_fin;
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

    function getCliente_id(){
        return $this->cliente_id ;
    }
    function getDisciplina_id(){
        return $this->disciplina_id;
    }
    function getSucursal_nit(){
        return $this->sucursal_nit;
    }
    function getFecha_inicio(){
        return $this->fecha_inicio;
    }
    function getFecha_fin(){
        return $this->fecha_fin;
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
    function obtenerInscritos(){
        $conectar = new ConexionPDO();

        $query = "SELECT id_inscripcion, cliente_id, disciplina_id, sucursal_nit, fecha_inicio, fecha_fin, created_at, updated_at, logico FROM inscripcion WHERE fecha_inicio LIKE '2021-%';";
        $consulta = $conectar->getConexion()->prepare($query);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($resultado);
    }

    // FUNCION OBTENER UN INSCRITO
    function obtenerInscrito(){
        $conectar = new ConexionPDO();

        $query = "SELECT id_inscripcion, cliente_id, disciplina_id, sucursal_nit, fecha_inicio, fecha_fin, created_at, updated_at, logico FROM inscripcion WHERE id_inscripcion=:id_inscripcion";
        $consulta = $conectar->getConexion()->prepare($query);
        $consulta->bindParam(':id_inscripcion',$_GET['id_inscripcion'],PDO::PARAM_INT);  
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($resultado);
    }

    // FUNCION REGISTRAR INSCRIPCION CON UN NUEVO CLIENTE
    function registrarInscripcion(){
        $query1 = 'INSERT INTO cliente (ci, ap_pat, ap_mat, nombre, correo, direccion, nro_celular) values (:ci, :ap_pat, :ap_mat, :nombre, :correo, :direccion, :nro_celular);';
        $query2 = 'INSERT INTO inscripcion (cliente_id, disciplina_id, sucursal_nit, fecha_inicio, fecha_fin) values (:cliente_id, :disciplina_id, :sucursal_nit, :fecha_inicio, :fecha_fin);';
        try {
            $conectar = new ConexionPDO();
            
            $consulta = $conectar->getConexion()->prepare($query1);
            $consulta->bindParam(':ci',$_POST['ci'],PDO::PARAM_INT);
            $consulta->bindParam(':ap_pat',$_POST['ap_pat'],PDO::PARAM_STR);
            $consulta->bindParam(':ap_mat',$_POST['ap_mat'],PDO::PARAM_STR);
            $consulta->bindParam(':nombre',$_POST['nombre'],PDO::PARAM_STR);
            $consulta->bindParam(':correo',$_POST['correo'],PDO::PARAM_STR);
            $consulta->bindParam(':direccion',$_POST['direccion'],PDO::PARAM_STR);
            $consulta->bindParam(':nro_celular',$_POST['nro_celular'],PDO::PARAM_INT);
            $consulta->execute(); 

            $msg = $conectar->getConexion()->lastInsertId();
            echo  'Regsitro de usuario exitoso, id:' . json_encode($msg);
            
            $consulta1 = $conectar->getConexion()->prepare($query2);
            $consulta1->bindParam(':cliente_id',$msg,PDO::PARAM_INT);
            $consulta1->bindParam(':disciplina_id',$_POST['disciplina_id'],PDO::PARAM_INT);
            $consulta1->bindParam(':sucursal_nit',$_POST['sucursal_nit'],PDO::PARAM_INT);
            $consulta1->bindParam(':fecha_inicio',$_POST['fecha_inicio'],PDO::PARAM_STR);
            $consulta1->bindParam(':fecha_fin',$_POST['fecha_fin'],PDO::PARAM_STR);
            $consulta1->execute();
            
            $msg1 = $conectar->getConexion()->lastInsertId();
            echo 'Regsitro de inscripción exitoso, id:' . json_encode($msg1);
            }

        catch(PDOException $error){
            $msg = array('msg' => "ERROR AL EJECUTAR INSERT");  
            echo json_encode($msg);
        }
    }

    // FUNCION REGISTRAR INSCRIPCION CON UN CLIENTE ANTIGUO
    function añadirInscripcion(){
        $query = 'INSERT INTO inscripcion (cliente_id, disciplina_id, sucursal_nit, fecha_inicio, fecha_fin) values (:cliente_id, :disciplina_id, :sucursal_nit, :fecha_inicio, :fecha_fin);';
        try {
            $conectar = new ConexionPDO();

            $consulta = $conectar->getConexion()->prepare($query);
            $consulta->bindParam(':cliente_id',$_GET['cliente_id'],PDO::PARAM_INT);
            $consulta->bindParam(':disciplina_id',$_POST['disciplina_id'],PDO::PARAM_INT);
            $consulta->bindParam(':sucursal_nit',$_POST['sucursal_nit'],PDO::PARAM_INT);
            $consulta->bindParam(':fecha_inicio',$_POST['fecha_inicio'],PDO::PARAM_STR);
            $consulta->bindParam(':fecha_fin',$_POST['fecha_fin'],PDO::PARAM_STR);
            $consulta->execute(); 

            $msg = array('data'=> $conectar->getConexion()->lastInsertId());
            echo json_encode($msg);
            }

        catch(PDOException $error){
            $msg = array('msg' => "ERROR AL EJECUTAR INSERT");  
            echo 'Registro de inscripción de cliente antiguo exitosa, id:' . json_encode($msg);
        }
    }

    //FUNCION PARA MODIFICAR INSCRIPCIÓN
    function actualizarInscripcion(){
        $query = 'UPDATE inscripcion set cliente_id=:cliente_id, disciplina_id=:disciplina_id, sucursal_nit=:sucursal_nit, fecha_inicio=:fecha_inicio, fecha_fin=:fecha_fin, created_at=:created_at, updated_at=:updated_at, logico=:logico WHERE id_inscripcion=:id_inscripcion;';
        try {
            $conectar = new ConexionPDO();

            $consulta = $conectar->getConexion()->prepare($query);          
            $consulta->bindParam(':cliente_id',$_POST['cliente_id'],PDO::PARAM_INT);
            $consulta->bindParam(':disciplina_id',$_POST['disciplina_id'],PDO::PARAM_INT);
            $consulta->bindParam(':sucursal_nit',$_POST['sucursal_nit'],PDO::PARAM_INT);
            $consulta->bindParam(':fecha_inicio',$_POST['fecha_inicio'],PDO::PARAM_STR);
            $consulta->bindParam(':fecha_fin',$_POST['fecha_fin'],PDO::PARAM_STR);
            $consulta->bindParam (":created_at", $_POST['ceated_at'], PDO::PARAM_STR);
            $consulta->bindParam (":updated_at", $_POST['updated_at'], PDO::PARAM_STR);
            $consulta->bindParam(':logico',$_POST['logico'],PDO::PARAM_INT);
            $consulta->bindParam(':id_inscripcion',$_GET['id_inscripcion'],PDO::PARAM_INT);  
            // var_dump($consulta);
            $consulta->execute();
            
            $mensaje = array('data' => "Registro actualizado");
            echo json_encode($mensaje);

        }
        catch(PDOException $error){
            $mensaje = array('mensaje' => "Error al ejecutar UPDATE");
            echo json_encode($mensaje);
        }
    }

    //FUNCION PARA ACTUALIZAR UN CAMPO DE UNA INSCRIPCIÓN
    function actualizarCampoInscripcion(){
        $setvalues='';
        foreach($_GET as $elem => $valor){
            if($elem!='id_inscripcion'){
                $setvalues=$setvalues .''. $elem . '="' . $valor. '"';
            }
        }
        $query = 'UPDATE inscripcion set '. $setvalues .' WHERE id_inscripcion=:id_inscripcion;';
        echo $query;
        try {
            $conectar = new ConexionPDO();

            $consulta = $conectar->getConexion()->prepare($query);          
            $consulta->bindParam(':id_inscripcion',$_GET['id_inscripcion'],PDO::PARAM_INT);  
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
$i = new Inscripcion();

