<?php
require_once '../app/controllers/ReservationController.php';

$controller = new ReservationController();

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $response = $controller->create($data);
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
}