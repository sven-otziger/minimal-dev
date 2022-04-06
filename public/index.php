<?php

require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// 06 simple routing
$request = $_SERVER['REQUEST_URI'];
$main = new \Controller\MainController();
$main->route($request);
