<?php
include_once('../conexion.php');
class Cliente{
    private $id_cliente;
    private $ci;
    private $ap_pat;
    private $ap_mat;
    private $nombre;
    private $correo;
    private $direccion;
    private $nro_celular;
    private $created_at;
    private $updated_at;
    private $logico;

    function Cliente(){
        $this->id_cliente ="";
        $this->ci ="";
        $this->ap_pat ="";
        $this->ap_mat ="";
        $this->nombre ="";
        $this->correo ="";
        $this->direccion ="";
        $this->nro_celular ="";
        $this->created_at ="";
        $this->updated_at ="";
        $this->logico ="";
    }

    // SETTERS

    function setId_cliente($id_cliente){
        $this->id_cliente = $id_cliente;
    }
    function setCi($ci){
        $this->ci = $ci;        
    }
    function setAp_pat($ap_pat){
        $this->ap_pat = $ap_pat;        
    }
    function setAp_mat($ap_mat){
        $this->ap_mat = $ap_mat;        
    }
    function setNombre($nombre){
        $this->nombre = $nombre;        
    }
    function setCorreo($correo){
        $this->correo = $correo;        
    }
    function setDireccion($direccion){
        $this->direccion = $direccion;        
    }
    function setNro_celular($nro_celular){
        $this->nro_celular = $nro_celular;        
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

    function getId_cliente(){
        return $this->id_cliente;
    }
    function getCi(){
        return $this->ci ;
    }
    function getAp_pat(){
        return $this->ap_pat;
    }
    function getAp_mat(){
        return $this->ap_mat;
    }
    function getNombre(){
        return $this->nombre;
    }
    function getCorreo(){
        return $this->correo;
    }
    function getDireccion(){
        return $this->direccion;
    }
    
    function getNro_celular(){
        return $this->nro_celular;
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
    function obtenerCorreos(){
        $conectar = new ConexionPDO();

        $query = "SELECT correo FROM cliente;";
        $consulta = $conectar->getConexion()->prepare($query);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($resultado);
    }
}
$c = new Cliente();