<?php

declare(strict_types=1);

namespace Retro\Static;

class OrdinaryCounter
{
	public int $count = 0;

	public function __construct()
	{
		echo ++$this->count;
	}
}