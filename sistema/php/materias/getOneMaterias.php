<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$id = $_POST['id'];

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    //========================= Realizamos la consulta
    $consultaMaterias = "SELECT * FROM materias WHERE clave = '$id'";
    $resultadoMaterias = mysqli_query($db, $consultaMaterias);
    $countMaterias = mysqli_num_rows($resultadoMaterias);

    //========================= Formamos el JSON
    $materias = [];

    if ($countMaterias > 0 && $resultadoMaterias) {
        $rowMaterias = mysqli_fetch_assoc($resultadoMaterias);

        $id = $rowMaterias['clave'];
        $nombre = $rowMaterias['nombre'];
        $creditos = $rowMaterias['creditos'];

        $materias = [
            "ok" => true,
            "id" => utf8_encode($id),
            "nombre" => utf8_encode($nombre),
            "creditos" => utf8_encode($creditos),
        ];
    } else if ($countMaterias == 0 && $resultadoMaterias) {
        $materias = [
            "ok" => false,
            "msg" => "Sin datos en la DB"
        ];
    } else {
        $materias = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $materias = [
        "res" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($materias);
