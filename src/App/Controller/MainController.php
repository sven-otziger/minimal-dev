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
			default:
				require __DIR__ . '/../html/404.html';
		}

	}
}
