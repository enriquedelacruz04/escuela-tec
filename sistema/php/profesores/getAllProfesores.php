<?php
header("Content-Type: application/json");

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    //========================= Realizamos la consulta
    $consultaProfesores = "SELECT * FROM profesores";
    $resultadoProfesores = mysqli_query($db, $consultaProfesores);
    $countProfesores = mysqli_num_rows($resultadoProfesores);

    //========================= Formamos el JSON
    $profesores = [];

    if ($countProfesores > 0 && $resultadoProfesores) {
        while ($rowProfesores = mysqli_fetch_assoc($resultadoProfesores)) {

            $id = $rowProfesores['clave'];
            $nombre = $rowProfesores['nombre'];
            $direccion = $rowProfesores['direccion'];
            $hora = $rowProfesores['hora'];
            $telefono = $rowProfesores['telefono'];

            $profesores[] = [
                "ok" => true,
                "id" => utf8_encode($id),
                "nombre" => utf8_encode($nombre),
                "direccion" => utf8_encode($direccion),
                "hora" => utf8_encode($hora),
                "telefono" => utf8_encode($telefono),
            ];
        }

        //========================= Si la tabla esta vacia
    } else if ($countProfesores == 0 && $resultadoProfesores) {
        $profesores[] = [
            "ok" => false,
            "msg" => "Sin datos en la DB"
        ];

        //========================= Si hubo errores en la DB
    } else {
        $profesores[] = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $profesores[] = [
        "res" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($profesores);
