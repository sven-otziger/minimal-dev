<?php

declare(strict_types=1);

namespace Retro\Constructor;

class Animal
{
	public function __construct(
		private string $name,
		private string $species,
		private int    $age,
		private bool   $isEndangered
	)
	{
	}

	public function PrintAnimal()
	{
		$printString = "{$this->name} is a {$this->species} and {$this->age} years old.";
		$test = 1;

		if ($this->isEndangered) {
			$printString .= " Sadly, it is an endangered species";
		} else {
			$printString .= " Luckily, it is not endangered";
		}
		echo $printString;
	}

}