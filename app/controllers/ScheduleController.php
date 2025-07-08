<?php
require_once __DIR__ . '/../models/ScheduleModel.php';

class ScheduleController {
    public function getTimeSlots($date) {
        return ScheduleModel::getByDate($date);
    }
}
