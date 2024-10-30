<?php
namespace VehicleManagement;

trait PriceTrait {
    public $price;

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }
}

abstract class Vehicle {
    protected $brand;
    protected $model;

    public function __construct($brand, $model) {
        $this->brand = $brand;
        $this->model = $model;
    }

    abstract public function getInfo();

    public function getBrand() {
        return $this->brand;
    }

    public function getModel() {
        return $this->model;
    }
}

class Car extends Vehicle {
    use PriceTrait;
    private $doors;

    public function __construct($brand, $model, $doors) {
        parent::__construct($brand, $model);
        $this->doors = $doors;
    }

    public function getInfo() {
        return "Car: {$this->brand} {$this->model}, Doors: {$this->doors}, Price: {$this->getPrice()}";
    }
}

class Motorcycle extends Vehicle {
    use PriceTrait;
    private $type;

    public function __construct($brand, $model, $type) {
        parent::__construct($brand, $model);
        $this->type = $type;
    }

    public function getInfo() {
        return "Motorcycle: {$this->brand} {$this->model}, Type: {$this->type}, Price: {$this->getPrice()}";
    }
}
?>
