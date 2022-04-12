<?php

declare(strict_types=1);

namespace Retro\Constructor;

class Person
{
	private string $name;
	private int $age;
	private int $height;
	private array $interests = [];

	public function __construct(string $name, int $age, int $height, array $interests)
	{
		$this->name = $name;
		$this->age = $age;
		$this->height = $height;
		$this->interests = $interests;
	}

	public function PrintPerson()
	{
		$printInterests = '';
		$length = count($this->interests);
		for ($i = 0; $i < $length; $i++) {
			if ($i === $length - 1) {
				$printInterests .= " and {$this->interests[$i]}.";
			} else {
				if ($i === $length - 2) {
					$printInterests .= "{$this->interests[$i]} ";

				} else {
					$printInterests .= "{$this->interests[$i]}, ";

				}

			}
		}

		echo "{$this->name} is {$this->age} year old and {$this->height}cm tall. This person likes {$printInterests}<br><br>";
	}

}