<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$id = utf8_decode($_POST['clave']);
$nombre = utf8_decode($_POST['nombre']);
$horario = utf8_decode($_POST['horario']);
$dias = utf8_decode($_POST['dias']);
$edit = utf8_decode($_POST['edit']);

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    if ($edit == '0') {

        //========================= Realizamos la consulta
        $consultaTrabajos = "INSERT INTO trabajos
        (
        clave,
        nombre,
        horario,
        dias
        )
        VALUES 
        (
        '$id',
        '$nombre',
        '$horario',
        '$dias'
        )";

        $resultadoTrabajos = mysqli_query($db, $consultaTrabajos);
    } else {

        //========================= Realizamos la consulta
        $consultaTrabajos = "UPDATE trabajos SET 
        clave = '$id',
        nombre = '$nombre',
        horario = '$horario',
        dias = '$dias'

        WHERE clave = '$edit'";
        $resultadoTrabajos = mysqli_query($db, $consultaTrabajos);
    }

    //========================= Formamos el JSON
    $trabajos = [];

    if ($resultadoTrabajos) {
        $trabajos = [
            "ok" => true,
        ];
    } else {
        $trabajos = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $trabajos = [
        "ok" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($trabajos);
