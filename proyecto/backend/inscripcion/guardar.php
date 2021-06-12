<?php

include('../conexion.php');
if(isset($_POST['guardar'])){
    $ci = $_POST['ci'];
    $nombre= $_POST['nombre'];
    $correo= $_POST['correo'];
    $edad= $_POST['edad'];
    $celular=$_POST['celular'];
    $disciplina = $_POST['disciplina'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    $query= "SELECT*FROM cliente where ci='$ci'";
    $existe=mysqli_query($conexion, $query);
    $filas = array();
    while ($fila=mysqli_fetch_array($existe, MYSQLI_ASSOC)) {
        $filas[] = $fila; // Añade el array $fila al final de $filas
    }

    $size = sizeof($filas);
    if(sizeof($filas) == 0){
        $query1= "INSERT INTO cliente(ci, nombre, correo, celular, edad) VALUES ('$ci', '$nombre',' $correo', '$celular', '$edad')";
        $resultado1=mysqli_query($conexion, $query1);
        if(!$resultado1){
            die('Query 1failed');
        }
        else{
            $query2 = "INSERT INTO inscripcion(ci, id, fecha_inicio, fecha_fin) VALUES ('$ci', '$disciplina',' $fecha_inicio', '$fecha_vencimiento')";
            $resultado2=mysqli_query($conexion, $query2);
            if(!$resultado2){
                die('Query 2 failed');
            }
            else{
                header("Location: /proyecto/frontend/html/registro.html");
            }
        }
    }
    else{
        $query2 = "INSERT INTO inscripcion(ci, id, fecha_inicio, fecha_fin) VALUES ('$ci', '$disciplina',' $fecha_inicio', '$fecha_vencimiento')";
        $resultado2=mysqli_query($conexion, $query2);
        if(!$resultado2){
            die('Query 2 failed');
        }
        else{
            header("Location: /proyecto/frontend/html/registro.html");
        }
    }




    // 
    // $resultado=mysqli_query($conexion, $query);
    // if(!$resultado){
    //     die('');
    // }
    // else{
    //     header("Location: /proyecto/frontend/html/registro.html");
    // }

    // $query = "INSERT INTO inscripcion(ci, id, fecha_inicio, fecha_fin) VALUES ('$ci', '$disciplina',' $fecha_inicio', '$fecha_vencimiento')";
    // $resultado=mysqli_query($conexion, $query);
    // if(!$resultado){
    //     die('Query failed');
    // }
}
