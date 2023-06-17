<?php
class TSM_Car_Rental_Price_Period
{
    private $id;
    private $car_id;
    private $start_date;
    private $end_date;
    private $price_per_day;

    public function __construct($id, $car_id, $start_date, $end_date, $price_per_day)
    {
        $this->id = $id;
        $this->car_id = $car_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->price_per_day = $price_per_day;
    }

    // Include getter and setter methods for each property here.
}
