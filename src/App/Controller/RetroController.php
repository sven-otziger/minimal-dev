<?php

namespace Controller;

class RetroController
{
	public function controller() {
		require __DIR__ . '/../../Retro/Constructor/index.php';
	}

	public function namespaces() {
		require __DIR__ . '/../../Retro/Namespaces/index.php';
	}

	public function counter() {
		require __DIR__ . '/../../Retro/Static/index.php';
	}

	public function inheritance() {
		require __DIR__ . '/../../Retro/Inheritance/index.php';
	}
}
