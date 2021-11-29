<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$id = utf8_decode($_POST['clave']);
$nombre = utf8_decode($_POST['nombre']);
$direccion = utf8_decode($_POST['direccion']);
$hora = utf8_decode($_POST['hora']);
$telefono = utf8_decode($_POST['telefono']);
$edit = utf8_decode($_POST['edit']);

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    if ($edit == '0') {

        //========================= Realizamos la consulta
        $consultaProfesores = "INSERT INTO profesores
        (
        clave,
        nombre,
        direccion,
        hora,
        telefono
        )
        VALUES 
        (
        '$id',
        '$nombre',
        '$direccion',
        '$hora',
        '$telefono'
        )";

        $resultadoProfesores = mysqli_query($db, $consultaProfesores);
    } else {

        //========================= Realizamos la consulta
        $consultaProfesores = "UPDATE profesores SET 
        clave = '$id',
        nombre = '$nombre',
        direccion = '$direccion',
        hora = '$hora',
        telefono = '$telefono'

        WHERE clave = '$edit'";
        $resultadoProfesores = mysqli_query($db, $consultaProfesores);
    }

    //========================= Formamos el JSON
    $profesores = [];

    if ($resultadoProfesores) {
        $profesores = [
            "ok" => true,
        ];
    } else {
        $profesores = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $profesores = [
        "ok" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($profesores);
