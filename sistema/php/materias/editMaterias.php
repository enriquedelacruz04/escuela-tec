<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$id = utf8_decode($_POST['clave']);
$nombre = utf8_decode($_POST['nombre']);
$creditos = utf8_decode($_POST['creditos']);
$edit = utf8_decode($_POST['edit']);

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    if ($edit == '0') {

        //========================= Realizamos la consulta
        $consultaMaterias = "INSERT INTO materias
        (
        clave,
        nombre,
        creditos
        )
        VALUES 
        (
        '$id',
        '$nombre',
        '$creditos'
        )";

        $resultadoMaterias = mysqli_query($db, $consultaMaterias);
    } else {

        //========================= Realizamos la consulta
        $consultaMaterias = "UPDATE materias SET 
        clave = '$id',
        nombre = '$nombre',
        creditos = '$creditos'

        WHERE clave = '$edit'";
        $resultadoMaterias = mysqli_query($db, $consultaMaterias);
    }

    //========================= Formamos el JSON
    $materias = [];

    if ($resultadoMaterias) {
        $materias = [
            "ok" => true,
        ];
    } else {
        $materias = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $materias = [
        "ok" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($materias);
