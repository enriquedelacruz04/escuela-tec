<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$id = $_POST['id'];

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    //========================= Realizamos la consulta
    $consultaCursos = "SELECT * FROM cursos WHERE clave = '$id'";
    $resultadoCursos = mysqli_query($db, $consultaCursos);
    $countCursos = mysqli_num_rows($resultadoCursos);

    //========================= Formamos el JSON
    $cursos = [];

    if ($countCursos > 0 && $resultadoCursos) {
        $rowCursos = mysqli_fetch_assoc($resultadoCursos);

        $id = $rowCursos['clave'];
        $nombre = $rowCursos['nombre'];
        $duracion = $rowCursos['duracion'];

        $cursos = [
            "ok" => true,
            "id" => utf8_encode($id),
            "nombre" => utf8_encode($nombre),
            "duracion" => utf8_encode($duracion),
        ];
    } else if ($countCursos == 0 && $resultadoCursos) {
        $cursos = [
            "ok" => false,
            "msg" => "Sin datos en la DB"
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
        "res" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($cursos);
