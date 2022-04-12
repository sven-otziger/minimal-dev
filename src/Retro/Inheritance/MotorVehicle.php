<?php

namespace Retro\Inheritance;

abstract class MotorVehicle
{
	protected string $owner;
	protected string $brand;
	protected string $model;
	protected int $yearOfManufacture;

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