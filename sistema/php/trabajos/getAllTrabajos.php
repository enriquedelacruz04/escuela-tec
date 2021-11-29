<?php
header("Content-Type: application/json");

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    //========================= Realizamos la consulta
    $consultaTrabajos = "SELECT * FROM trabajos";
    $resultadoTrabajos = mysqli_query($db, $consultaTrabajos);
    $countTrabajos = mysqli_num_rows($resultadoTrabajos);

    //========================= Formamos el JSON
    $trabajos = [];

    if ($countTrabajos > 0 && $resultadoTrabajos) {
        while ($rowTrabajos = mysqli_fetch_assoc($resultadoTrabajos)) {

            $id = $rowTrabajos['clave'];
            $nombre = $rowTrabajos['nombre'];
            $horario = $rowTrabajos['horario'];
            $dias = $rowTrabajos['dias'];

            $trabajos[] = [
                "ok" => true,
                "id" => utf8_encode($id),
                "nombre" => utf8_encode($nombre),
                "horario" => utf8_encode($horario),
                "dias" => utf8_encode($dias),
            ];
        }

        //========================= Si la tabla esta vacia
    } else if ($countTrabajos == 0 && $resultadoTrabajos) {
        $trabajos[] = [
            "ok" => false,
            "msg" => "Sin datos en la DB"
        ];

        //========================= Si hubo errores en la DB
    } else {
        $trabajos[] = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $trabajos[] = [
        "res" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($trabajos);
