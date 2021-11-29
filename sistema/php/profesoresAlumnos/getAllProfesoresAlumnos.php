<?php
header("Content-Type: application/json");

//========================= Parametros que nos llegan por GET
$profesores = $_POST['profesores'];

//========================= Importamos la conexion
require '../includes/conexion.php';

try {
    //========================= Realizamos la consulta
    $consultaProfesoresAlumnos = "SELECT * FROM profesores_alumnos WHERE profesores_clave = '$profesores'";
    $resultadoProfesoresAlumnos = mysqli_query($db, $consultaProfesoresAlumnos);
    $countProfesoresAlumnos = mysqli_num_rows($resultadoProfesoresAlumnos);

    //========================= Formamos el JSON
    $profesoresAlumnos = [];

    if ($countProfesoresAlumnos > 0 && $resultadoProfesoresAlumnos) {
        while ($rowProfesoresAlumnos = mysqli_fetch_assoc($resultadoProfesoresAlumnos)) {

            $id = $rowProfesoresAlumnos['idprofesores_alumnos'];
            $profesores = $rowProfesoresAlumnos['profesores_clave'];
            $alumnos = $rowProfesoresAlumnos['alumnos_matricula'];

            //========================= Nombre del alumno
            $consultaAlumnos = "SELECT * FROM alumnos WHERE matricula = '$alumnos'";
            $resultadoAlumnos = mysqli_query($db, $consultaAlumnos);
            $rowAlumnos = mysqli_fetch_assoc($resultadoAlumnos);

            $nombreAlumnos = $rowAlumnos['nombre'];

            $profesoresAlumnos[] = [
                "ok" => true,
                "id" => utf8_encode($id),
                "profesores" => utf8_encode($profesores),
                "alumnos" => utf8_encode($nombreAlumnos),
            ];
        }

        //========================= Si la tabla esta vacia
    } else if ($countProfesoresAlumnos == 0 && $resultadoProfesoresAlumnos) {
        $profesoresAlumnos[] = [
            "ok" => false,
            "msg" => "Sin datos en la DB"
        ];

        //========================= Si hubo errores en la DB
    } else {
        $profesoresAlumnos[] = [
            "ok" => false,
            "msg" => "Error en la DB"
        ];
    }
} catch (\Throwable $th) {
    throw $th;
    var_dump($th);

    $profesoresAlumnos[] = [
        "res" => false,
        "msg" => "Error en la DB"
    ];
}

//========================= Imprimimos el JSON
echo json_encode($profesoresAlumnos);
