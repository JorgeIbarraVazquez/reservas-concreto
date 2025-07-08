<?php
require_once __DIR__ . '/../models/ReservationModel.php';

class ReservationController
{
    public function create($data)
    {
        return ReservationModel::save($data);
    }


    public function getByDate($date)
    {
        return ReservationModel::getByDate($date);
    }

    public function getAll()
    {
        return ReservationModel::getAll();
    }
}
