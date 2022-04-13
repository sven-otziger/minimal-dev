<?php

use Controller\BlogController;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

require '../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// routing with symfony
// ::class		returns fully qualified classname
$routeSource = [
	[
		'path' => '/blog/{slug}',
		'controller' => ['_controller' => BlogController::class],
		'name' => 'blog_show'
	],
	[
		'path' => '/demo/index',
		'controller' => ['_controller' => \Controller\DemoController::class],
		'name' => 'route'
	],
	[
		'path' => '/retro/{slug}',
		'controller' => ['_controller' => \Controller\RetroController::class],
		'name' => 'serialization'
	]

];
// stores a combination of path and route
$routes = new RouteCollection();

foreach ($routeSource as $item) {
	$route = new Route($item['path'], $item['controller']);
	$routes->add($item['name'], $route);
}

$context = new RequestContext();
$context->setPathInfo($_SERVER['REQUEST_URI']);

$matcher = new UrlMatcher($routes, $context);
$parameters = $matcher->match($context->getPathInfo());

// creates controller depending on the request and calls method accordingly
$controller = new $parameters['_controller']($parameters);
call_user_func(array($controller, $parameters['_route']));
