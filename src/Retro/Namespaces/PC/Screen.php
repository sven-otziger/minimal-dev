<?php

namespace Retro\Namespaces\PC;

class Screen
{
	public function __construct(
		public string $brand,
		public string $model,
		public int    $price
	)
	{
	}
}