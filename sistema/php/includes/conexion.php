<?php

// $db = mysqli_connect('localhost', 'root', 'root', 'dbescuela');
$db = mysqli_connect('localhost', 'id18026148_root', 'aWXN(5\4PM5YCsu~', 'id18026148_dbescuela');


if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
} else {
    // echo "conexion correcta";
}
