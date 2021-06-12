<?php
include_once('../conexion.php');
class Usuario {
    private $ci;
    private $nombre;
    private $username;
    private $correo;
    private $celular;
    private $password;
    private $created_at;
    private $updated_at;
    private $logico;
    
    function Usuario(){
        $this->ci = "";
        $this->nombre = "";
        $this->username = "";
        $this->correo = "";
        $this->celular =  "";
        $this->password = "";
        $this->created_at= "";
        $this->updated_at= "";
        $this->logico= "";
    }

    // SETTERS

    function setci($ci){
        $this->ci = $ci;
    }
    function setnombre($nombre){
        $this->nombre = $nombre;
    }
    function setusername($username){
        $this->username = $username;
    }
    function setcorreo($correo){
        $this->correo = $correo;
    }
    function setcelular($celular){
        $this->celular = $celular;
    }
    function setpassword($password){
        $this->password = $password;
    }
    function setcreated_at($created_at){
        $this->created_at = $created_at;
    }
    function setupdated_at($updated_at){
        $this->updated_at = $updated_at;
    }
    function setlogico($logico){
        $this->logico= $logico;
    }

    //GETTERS
    function getci(){
        return $this->ci;
    }
    function getnombre(){
        return $this->nombre;
    }
    function getusername(){
        return $this->username;
    }
    function getcorreo(){
        return $this->correo;
    }
    function getcelular(){
        return $this->celular;
    }
    function getpassword(){
        return $this->password;
    }
    function getcreated_at(){
        return $this->created_at;
    }
    function getupdated_at(){
        return $this->updated_at;
    }
    function getlogico(){
        return $this->logico;
    }


    //FUNCION OBTENER USUARIO
    function obtenerUsuario(){
        $conectar = new ConexionPDO();

        $query = "SELECT * FROM usuario;";
        $consulta = $conectar->getConexion()->prepare($query);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($resultado);
    }

    //FUNCION AGREGAR USUARIO
    function insertarUsuario(){
        $query = 'INSERT INTO usuario (ci, nombre, username, correo, celular, password) values (:ci, :nombre, :username, :correo, :celular, MD5(:password));';
        try {
            $conectar = new ConexionPDO();

            $consulta = $conectar->getConexion()->prepare($query);
            $consulta->bindParam(':ci',$_POST['ci'],PDO::PARAM_INT);
            $consulta->bindParam(':nombre',$_POST['nombre'],PDO::PARAM_STR);
            $consulta->bindParam(':username',$_POST['username'],PDO::PARAM_STR);
            $consulta->bindParam(':correo',$_POST['correo'],PDO::PARAM_STR);
            $consulta->bindParam(':celular',$_POST['celular'],PDO::PARAM_INT);
            $consulta->bindParam(':password',$_POST['password'],PDO::PARAM_STR);
            $consulta->execute(); 

            // $msg = array('data' => $conectar->getConexion()->lastInsertId());
            // echo json_encode($msg);
            }
        catch(PDOException $e){
            $msg = array('msg' => "ERROR AL EJECUTAR INSERT");  
            echo json_encode($msg);
        }
    }

    //FUNCION PARA MODIFICAR USUARIO
    function actualizarUsuario(){
        $query = 'UPDATE usuario set nombre=:nombre, username=:username, correo=:correo, celular=:celular, password=MD5(:password), created_at=:created_at, updated_at=:updated_at, logico=:logico WHERE ci=:ci;';
        try {
            $conectar = new ConexionPDO();

            $consulta = $conectar->getConexion()->prepare($query);          
            $consulta->bindParam(':nombre',$_POST['nombre'],PDO::PARAM_STR);
            $consulta->bindParam(':username',$_POST['username'],PDO::PARAM_STR);
            $consulta->bindParam(':correo',$_POST['correo'],PDO::PARAM_STR);
            $consulta->bindParam(':celular',$_POST['celular'],PDO::PARAM_INT);
            $consulta->bindParam(':password',$_POST['password'],PDO::PARAM_STR);
            $consulta->bindParam (":created_at", $_POST['ceated_at'], PDO::PARAM_STR);
            $consulta->bindParam (":updated_at", $_POST['updated_at'], PDO::PARAM_STR);
            $consulta->bindParam(':logico',$_POST['logico'],PDO::PARAM_INT);
            $consulta->bindParam(':ci',$_GET['ci'],PDO::PARAM_INT);  
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
}

$u = new Usuario();