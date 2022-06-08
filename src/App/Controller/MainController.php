<?php

namespace Controller;

class MainController
{
	public function route($url)
	{
//		https://www.taniarascia.com/the-simplest-php-router/

		$url = str_replace("/", "", $url);
		switch ($url) {
			case 'index':
				$index = new IndexController();
				$index->route();
				break;
			case 'demo':
				$demo = new DemoController();
				$demo->route();
				break;
			case 'harambe':
				header("Location: https://bit.ly/3KiFSE9");
				break;
			case 'controller':
				$controller = new RetroController();
				$controller->controller();
				break;
			case 'namespaces':
				$namespace = new RetroController();
				$namespace->namespaces();
				break;
			case 'counter':
				$counter = new RetroController();
				$counter->counter();
				break;
			case 'inheritance':
				$inheritance = new RetroController();
				$inheritance->inheritance();
				break;
			default:
				require __DIR__ . '/../views/404.html';
		}

	}
}
