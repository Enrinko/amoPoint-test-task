<?php

require_once __DIR__. '/Connection.php';
use src\php\Connection;

header('Content-Type: application/json');
// Получаем данные из POST-запроса
$data = json_decode(file_get_contents("php://input"), true);
try {
    if (!$data) {
        throw new Exception("Invalid input data");
    }
    $connection = new Connection();
    $connection->create($data);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit;
}
