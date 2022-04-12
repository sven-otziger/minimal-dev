<?php

$car = new \Retro\Inheritance\Car("Olaf Berg", "Volvo", "XC60", 2013);

$car->accelerate()
	->refuel()
	->brake()
	->park()
	->showOffDetails()
	->showOffMotor();

echo '<br><br>';

$motorcycle = new \Retro\Inheritance\Motorcycle("Sam Martensen", "Yamaha", "MT07", 2016);
$motorcycle->accelerate()
			->refuel()
			->brake()
			->park()
			->showOffDetails()
			->showOffMotor();