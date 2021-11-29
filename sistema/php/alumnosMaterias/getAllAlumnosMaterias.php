<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$alumnos = $_POST['alumnos'];

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    //========================= Realizamos la consulta
    $consultaAlumnosMaterias = "SELECT * FROM alumnos_materias WHERE alumnos_matricula = '$alumnos'";
    $resultadoAlumnosMaterias = mysqli_query($db, $consultaAlumnosMaterias);
    $countAlumnosMaterias = mysqli_num_rows($resultadoAlumnosMaterias);

    //========================= Formamos el JSON
    $alumnosMaterias = [];

    if ($countAlumnosMaterias > 0 && $resultadoAlumnosMaterias) {
        while ($rowAlumnosMaterias = mysqli_fetch_assoc($resultadoAlumnosMaterias)) {

            $id = $rowAlumnosMaterias['idalumnos_materias'];
            $alumnos = $rowAlumnosMaterias['alumnos_matricula'];
            $materias = $rowAlumnosMaterias['materias_clave'];

            //========================= Nombre de la materia
            $consultaMaterias = "SELECT * FROM materias WHERE clave = '$materias'";
            $resultadoMaterias = mysqli_query($db, $consultaMaterias);
            $rowMaterias = mysqli_fetch_assoc($resultadoMaterias);

            $nombreMaterias = $rowMaterias['nombre'];

            $alumnosMaterias[] = [
                "ok" => true,
                "id" => utf8_encode($id),
                "alumnos" => utf8_encode($alumnos),
                "materias" => utf8_encode($nombreMaterias),
            ];
        }

        //========================= Si la tabla esta vacia
    } else if ($countAlumnosMaterias == 0 && $resultadoAlumnosMaterias) {
        $alumnosMaterias[] = [
            "ok" => false,
            "msg" => "Sin datos en la DB"
        ];

        //========================= Si hubo errores en la DB
    } else {
        $alumnosMaterias[] = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $alumnosMaterias[] = [
        "res" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($alumnosMaterias);
