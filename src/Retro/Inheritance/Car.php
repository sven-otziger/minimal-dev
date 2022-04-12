<?php

namespace Retro\Inheritance;

class Car extends MotorVehicle implements DriveMotorVehicleInterface
{
	public function __construct($owner, $brand, $model, $yearOfManufacture)
	{
		parent::__construct($owner, $brand, $model, $yearOfManufacture);
	}

	public function accelerate(): Car
	{
		echo 'Press the right pedal gently.<br>';
		return $this;
	}

	public function brake(): Car
	{
		echo 'Press the middle pedal gently.<br>';
		return $this;
	}

	public function shift(): Car
	{
		echo "Press the clutch with the left foot and shift with the right hand in the middle.<br>";
		return $this;
	}
}
