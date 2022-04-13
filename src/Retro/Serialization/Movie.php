<?php

namespace Retro\Serialization;

class Movie
{
	public function __construct(
		public string $name,
		public string $director,
		public array $actors,
		public int $releaseYear,
		public int $length
	)
	{
	}
}