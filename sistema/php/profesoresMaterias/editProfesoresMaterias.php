<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
// $id = utf8_decode($_POST['id']);
$profesores = utf8_decode($_POST['profesores']);
$materias = utf8_decode($_POST['materias']);
$edit = utf8_decode($_POST['edit']);

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    if ($edit == '0') {

        //========================= Realizamos la consulta
        $consultaProfesoresMaterias = "INSERT INTO profesores_materias
        (
        profesores_clave,
        materias_clave
        )
        VALUES 
        (
        '$profesores',
        '$materias'
        )";

        $resultadoProfesoresMaterias = mysqli_query($db, $consultaProfesoresMaterias);
    }

    //========================= Formamos el JSON
    $profesoresMaterias = [];

    if ($resultadoProfesoresMaterias) {
        $profesoresMaterias = [
            "ok" => true,
        ];
    } else {
        $profesoresMaterias = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $profesoresMaterias = [
        "ok" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($profesoresMaterias);
