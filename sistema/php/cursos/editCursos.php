<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$id = utf8_decode($_POST['clave']);
$nombre = utf8_decode($_POST['nombre']);
$duracion = utf8_decode($_POST['duracion']);
$edit = utf8_decode($_POST['edit']);

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    if ($edit == '0') {

        //========================= Realizamos la consulta
        $consultaCursos = "INSERT INTO cursos
        (
        clave,
        nombre,
        duracion
        )
        VALUES 
        (
        '$id',
        '$nombre',
        '$duracion'
        )";

        $resultadoCursos = mysqli_query($db, $consultaCursos);
    } else {

        //========================= Realizamos la consulta
        $consultaCursos = "UPDATE cursos SET 
        clave = '$id',
        nombre = '$nombre',
        duracion = '$duracion'

        WHERE clave = '$edit'";
        $resultadoCursos = mysqli_query($db, $consultaCursos);
    }

    //========================= Formamos el JSON
    $cursos = [];

    if ($resultadoCursos) {
        $cursos = [
            "ok" => true,
        ];
    } else {
        $cursos = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $cursos = [
        "ok" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($cursos);
