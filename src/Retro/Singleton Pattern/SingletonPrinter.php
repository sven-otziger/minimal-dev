<?php

namespace Controller;

class SingletonPrinter
{
	private static ?SingletonPrinter $singletonPrinter = null;

	private function __construct()
	{

	}

	public static function getSingletonPrinter(): SingletonPrinter
	{
		if (self::$singletonPrinter === null) {
			self::$singletonPrinter = new SingletonPrinter();
		}
		return self::$singletonPrinter;
	}

	public static function printName($name): void
	{
		echo $name;
	}
}