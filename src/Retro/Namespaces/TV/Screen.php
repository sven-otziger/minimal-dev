<?php

namespace Namespaces\TV;

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