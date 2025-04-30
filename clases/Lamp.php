<?php
class Lamp
{
    private $id, $name, $on, $model, $wattage, $zone;

    public function __construct($id, $name, $on, $model, $wattage, $zone)
    {
        $this->id = $id;
        $this->name = $name;
        $this->on = $on;
        $this->model = $model;
        $this->wattage = $wattage;
        $this->zone = $zone;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function isOn()
    {
        return $this->on;
    }
    public function getModel()
    {
        return $this->model;
    }
    public function getWattage()
    {
        return $this->wattage;
    }
    public function getZone()
    {
        return $this->zone;
    }
}
