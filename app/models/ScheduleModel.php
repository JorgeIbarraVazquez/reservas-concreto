<?php
require_once 'ReservationModel.php';

class ScheduleModel {
    public static function getDefaultTimeSlots() {
        return ['08:00', '10:00', '12:00', '14:00', '16:00'];
    }

    public static function getByDate($date) {
        $reservas = ReservationModel::getByDate($date);
        $ocupadas = array_column($reservas, 'time');

        $slots = [];
        foreach (self::getDefaultTimeSlots() as $hora) {
            $slots[$hora] = !in_array($hora, $ocupadas);
        }
        return $slots;
    }
}