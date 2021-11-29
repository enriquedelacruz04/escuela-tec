<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$profesores = utf8_decode($_POST['profesores']);
$alumnos = utf8_decode($_POST['alumnos']);
$edit = utf8_decode($_POST['edit']);

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    if ($edit == '0') {

        //========================= Realizamos la consulta
        $consultaProfesoresAlumnos = "INSERT INTO profesores_alumnos
        (
        profesores_clave,
        alumnos_matricula
        )
        VALUES 
        (
        '$profesores',
        '$alumnos'
        )";

        $resultadoProfesoresAlumnos = mysqli_query($db, $consultaProfesoresAlumnos);
    }

    //========================= Formamos el JSON
    $profesoresAlumnos = [];

    if ($resultadoProfesoresAlumnos) {
        $profesoresAlumnos = [
            "ok" => true,
        ];
    } else {
        $profesoresAlumnos = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $profesoresAlumnos = [
        "ok" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($profesoresAlumnos);
