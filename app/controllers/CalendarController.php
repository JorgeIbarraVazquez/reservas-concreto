<?php
require_once __DIR__ . '/../models/CalendarModel.php';

class CalendarController {
    public function getAvailability($year, $month) {
        return CalendarModel::getMonthAvailability($year, $month);

    }
}