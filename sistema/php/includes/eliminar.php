<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$id = $_POST['id'];
$idTabla = $_POST['idTabla'];
$tabla = $_POST['tabla'];

//========================= Importamos la conexion
require 'conexion.php';

try {

    //========================= Realizamos la consulta
    $consultaEliminar = "DELETE FROM $tabla WHERE $idTabla = '$id'";
    $resultadoEliminar = mysqli_query($db, $consultaEliminar);


    //========================= Formamos el JSON
    $array = [];
    if ($resultadoEliminar) {
        $array = [
            "ok" => true,
        ];
    } else {
        $array = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $array = [
        "ok" => false,
        "msg" => "Error en la DB"
    ];
}

echo json_encode($array);
