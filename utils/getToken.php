<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$token = "GHB3-12JNWFR-23JH3-12JH3"; // Token de acceso

// Leer entrada JSON
$input = json_decode(file_get_contents("php://input"), true);

if ($input['token'] === $token) {
    echo json_encode([
        "permitido" => true,
        "url_secreta" => "https://neurosense.mx/example/fake-login.html"
    ]);
} else {
    echo json_encode([
        "permitido" => false
    ]);
}
?>
