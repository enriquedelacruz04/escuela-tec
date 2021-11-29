<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$id = $_POST['id'];

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    //========================= Realizamos la consulta
    $consultaTrabajos = "SELECT * FROM trabajos WHERE clave = '$id'";
    $resultadoTrabajos = mysqli_query($db, $consultaTrabajos);
    $countTrabajos = mysqli_num_rows($resultadoTrabajos);

    //========================= Formamos el JSON
    $trabajos = [];

    if ($countTrabajos > 0 && $resultadoTrabajos) {
        $rowTrabajos = mysqli_fetch_assoc($resultadoTrabajos);

        $id = $rowTrabajos['clave'];
        $nombre = $rowTrabajos['nombre'];
        $horario = $rowTrabajos['horario'];
        $dias = $rowTrabajos['dias'];

        $trabajos = [
            "ok" => true,
            "id" => utf8_encode($id),
            "nombre" => utf8_encode($nombre),
            "horario" => utf8_encode($horario),
            "dias" => utf8_encode($dias),
        ];
    } else if ($countTrabajos == 0 && $resultadoTrabajos) {
        $trabajos = [
            "ok" => false,
            "msg" => "Sin datos en la DB"
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
        "res" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($trabajos);
