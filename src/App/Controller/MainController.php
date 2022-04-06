<?php

namespace Controller;

use App\IndexController;
use Sven\Demo\DemoController;

class MainController
{
	public function route($url)
	{
//		https://www.taniarascia.com/the-simplest-php-router/

		$url = str_replace("/", "", $url);
		switch ($url) {
			case 'index':
				$test = new IndexController();
				$test->index();
				break;
			case 'demo':
				$demo = new DemoController();
				$demo->index();
				break;
			case 'harambe':
				header("Location: https://cdn.prod.www.spiegel.de/images/8c84f10c-0001-0004-0000-000001001234_w920_r1.0666666666666667_fpx46.88_fpy50.jpg");
				break;
			default:
				require __DIR__ . '/../../html/404.php';
		}

	}
}