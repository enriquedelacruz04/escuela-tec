<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$id = utf8_decode($_POST['matricula']);
$nombre = utf8_decode($_POST['nombre']);
$edad = utf8_decode($_POST['edad']);
$genero = utf8_decode($_POST['genero']);
$semestre = utf8_decode($_POST['semestre']);
$cursos = utf8_decode($_POST['cursos']);
$trabajos = utf8_decode($_POST['trabajos']);
$edit = utf8_decode($_POST['edit']);

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    if ($edit == '0') {

        //========================= Realizamos la consulta
        $consultaAlumnos = "INSERT INTO alumnos
        (
        matricula,
        nombre,
        edad,
        genero,
        semestre,
        cursos_clave,
        trabajos_clave
        )
        VALUES 
        (
        '$id',
        '$nombre',
        '$edad',
        '$genero',
        '$semestre',
        '$cursos',
        '$trabajos'
        )";

        $resultadoAlumnos = mysqli_query($db, $consultaAlumnos);
    } else {

        //========================= Realizamos la consulta
        $consultaAlumnos = "UPDATE alumnos SET 
        matricula = '$id',
        nombre = '$nombre',
        edad = '$edad',
        genero = '$genero',
        semestre = '$semestre',
        cursos_clave = '$cursos',
        trabajos_clave = '$trabajos'

        WHERE matricula = '$edit'";
        $resultadoAlumnos = mysqli_query($db, $consultaAlumnos);
    }

    //========================= Formamos el JSON
    $alumnos = [];

    if ($resultadoAlumnos) {
        $alumnos = [
            "ok" => true,
        ];
    } else {
        $alumnos = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $alumnos = [
        "ok" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($alumnos);
