<?php

declare(strict_types=1);

namespace Retro\Static;

class StaticCounter
{
	public static int $count = 0;

	public function __construct()
	{
		echo ++StaticCounter::$count;
	}
}