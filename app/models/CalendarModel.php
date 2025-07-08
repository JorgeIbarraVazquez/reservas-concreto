<?php
require_once 'ScheduleModel.php';

class CalendarModel {
    public static function getMonthAvailability($year, $month) {
        $availability = [];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $fecha = sprintf("%04d-%02d-%02d", $year, $month, $d);
            $slots = ScheduleModel::getByDate($fecha);
            $availability[$fecha] = in_array(true, $slots); // true si hay al menos una hora libre
        }

        return $availability;
    }
}