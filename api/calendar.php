<?php
require_once '../app/controllers/CalendarController.php';

$controller = new CalendarController();

$year = 2025;
$month = 9;

$availability = $controller->getAvailability($year, $month);

echo json_encode($availability);