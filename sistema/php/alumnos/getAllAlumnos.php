<?php
header("Content-Type: application/json");

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    //========================= Realizamos la consulta
    $consultaAlumnos = "SELECT * FROM alumnos";
    $resultadoAlumnos = mysqli_query($db, $consultaAlumnos);
    $countAlumnos = mysqli_num_rows($resultadoAlumnos);

    //========================= Formamos el JSON
    $alumnos = [];

    if ($countAlumnos > 0 && $resultadoAlumnos) {
        while ($rowAlumnos = mysqli_fetch_assoc($resultadoAlumnos)) {

            $id = $rowAlumnos['matricula'];
            $nombre = $rowAlumnos['nombre'];
            $genero = $rowAlumnos['genero'];
            $edad = $rowAlumnos['edad'];
            $semestre = $rowAlumnos['semestre'];
            $cursos = $rowAlumnos['cursos_clave'];
            $clave = $rowAlumnos['trabajos_clave'];

            $alumnos[] = [
                "ok" => true,
                "id" => utf8_encode($id),
                "nombre" => utf8_encode($nombre),
                "edad" => utf8_encode($edad),
                "genero" => utf8_encode($genero),
                "semestre" => utf8_encode($semestre),
                "cursos" => utf8_encode($cursos),
                "clave" => utf8_encode($clave),
            ];
        }

        //========================= Si la tabla esta vacia
    } else if ($countAlumnos == 0 && $resultadoAlumnos) {
        $alumnos[] = [
            "ok" => false,
            "msg" => "Sin datos en la DB"
        ];

        //========================= Si hubo errores en la DB
    } else {
        $alumnos[] = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $alumnos[] = [
        "res" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($alumnos);
