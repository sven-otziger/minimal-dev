<?php

namespace Retro\Inheritance;

abstract class MotorVehicle
{
	use ShowOffMotorVehicle;

	public string $owner;
	public string $brand;
	public string $model;
	public int $yearOfManufacture;

	public function __construct($owner, $brand, $model, $yearOfManufacture)
	{
		$this->owner = $owner;
		$this->brand = $brand;
		$this->model = $model;
		$this->yearOfManufacture = $yearOfManufacture;
	}

	public function refuel(): MotorVehicle
	{
		echo "The vehicle has been refilled.<br>";
		return $this;
	}

	public function park(): MotorVehicle {
		echo "The vehicle has been parked.<br>";
		return $this;
	}

}