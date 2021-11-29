<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$profesores = $_POST['profesores'];

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    //========================= Realizamos la consulta
    $consultaProfesoresMaterias = "SELECT * FROM profesores_materias WHERE profesores_clave = '$profesores'";
    $resultadoProfesoresMaterias = mysqli_query($db, $consultaProfesoresMaterias);
    $countProfesoresMaterias = mysqli_num_rows($resultadoProfesoresMaterias);

    //========================= Formamos el JSON
    $profesoresMaterias = [];

    if ($countProfesoresMaterias > 0 && $resultadoProfesoresMaterias) {
        while ($rowProfesoresMaterias = mysqli_fetch_assoc($resultadoProfesoresMaterias)) {

            $id = $rowProfesoresMaterias['idprofesores_materias'];
            $profesores = $rowProfesoresMaterias['profesores_clave'];
            $materias = $rowProfesoresMaterias['materias_clave'];

             //========================= Nombre de la materia
             $consultaMaterias = "SELECT * FROM materias WHERE clave = '$materias'";
             $resultadoMaterias = mysqli_query($db, $consultaMaterias);
             $rowMaterias = mysqli_fetch_assoc($resultadoMaterias);
 
             $nombreMaterias = $rowMaterias['nombre'];

            $profesoresMaterias[] = [
                "ok" => true,
                "id" => utf8_encode($id),
                "profesores" => utf8_encode($profesores),
                "materias" => utf8_encode($nombreMaterias),
            ];
        }

        //========================= Si la tabla esta vacia
    } else if ($countProfesoresMaterias == 0 && $resultadoProfesoresMaterias) {
        $profesoresMaterias[] = [
            "ok" => false,
            "msg" => "Sin datos en la DB"
        ];

        //========================= Si hubo errores en la DB
    } else {
        $profesoresMaterias[] = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $profesoresMaterias[] = [
        "res" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($profesoresMaterias);
