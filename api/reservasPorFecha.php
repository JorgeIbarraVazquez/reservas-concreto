<?php
require_once '../app/controllers/ReservationController.php';

$controller = new ReservationController();
$date = $_GET['date'] ?? null;

if ($date) {
    $reservas = $controller->getByDate($date);
    echo json_encode(array_values($reservas)); // 🔑 para evitar objetos con índices perdidos
} else {
    echo json_encode([]);
}