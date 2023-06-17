<?php
class TSM_Car_Rental_Car
{
    private $id;
    private $make;
    private $model;
    private $year;

    public function __construct($id, $make, $model, $year, $price_per_day)
    {
        $this->id = $id;
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
    }

    // Include getter and setter methods for each property here.
}
