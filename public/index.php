<?php

require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

//phpinfo();

try {
	throw new Exception('My Exception');
} catch (Exception $e) {
	echo $e->getMessage() . ' in file ' . $e->getFile() . ' on line ' . $e->getLine() . '<br>';
};

//$myObj = new \Sven\Demo\DemoController();
//$myObj->index();

$indexController = new \App\IndexController();
$indexController->index();

$myBoat = new \Test\Boat();
$myBoat->index();