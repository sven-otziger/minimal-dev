<?php

namespace Retro\Inheritance;

class Motorcycle extends MotorVehicle implements DriveMotorVehicleInterface
{
	public function __construct($owner, $brand, $model, $yearOfManufacture)
	{
		parent::__construct($owner, $brand, $model, $yearOfManufacture);
	}

	public function accelerate(): Motorcycle
	{
		echo 'Turn the right side of the handlebar slowly towards you<br>';
		return $this;
	}

	public function brake(): Motorcycle
	{
		echo 'There are two brakes you can use: the rear one with your right foot or the front one with your right hand.<br>';
		return $this;
	}

	public function shift(): Motorcycle
	{
		echo 'Pull the clutch on the left side of the handlebar and shift with your left foot, slowly release the clutch.<br>';
		return $this;
	}
}
