<?php

namespace Retro\Inheritance;

trait ShowOffMotorVehicle
{
	public function showOffDetails(): MotorVehicle
	{
		echo "Owner: {$this->owner}<br>" .
			"Brand: {$this->brand}<br>" .
			"Model: {$this->model}<br>" .
			"Manufactured year: {$this->yearOfManufacture}<br>";
		return $this;
	}

	public function showOffMotor(): MotorVehicle {
		echo "<i>{$this->brand} {$this->model} revs the motor.</i><br>";
		return $this;
	}
}
