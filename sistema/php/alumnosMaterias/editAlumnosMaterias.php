<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$alumnos = utf8_decode($_POST['alumnos']);
$materias = utf8_decode($_POST['materias']);
$edit = utf8_decode($_POST['edit']);

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    if ($edit == '0') {

        //========================= Realizamos la consulta
        $consultaAlumnosMaterias = "INSERT INTO alumnos_materias
        (
        alumnos_matricula,
        materias_clave
        )
        VALUES 
        (
        '$alumnos',
        '$materias'
        )";

        $resultadoAlumnosMaterias = mysqli_query($db, $consultaAlumnosMaterias);
    }

    //========================= Formamos el JSON
    $alumnosMaterias = [];

    if ($resultadoAlumnosMaterias) {
        $alumnosMaterias = [
            "ok" => true,
        ];
    } else {
        $alumnosMaterias = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $alumnosMaterias = [
        "ok" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($alumnosMaterias);
