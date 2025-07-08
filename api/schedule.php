<?php
require_once '../app/controllers/ScheduleController.php';
header('Content-Type: application/json');

$date = $_GET['date'];
$controller = new ScheduleController();
echo json_encode($controller->getTimeSlots($date));