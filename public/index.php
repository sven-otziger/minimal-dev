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

// get routes from extern file
$routeSource = require_once __DIR__ . "/../src/App/Routes/routes.php";

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

$arguments = array_filter($parameters, function ($index) {
	return ($index != '_controller' && $index != '_route');
}, ARRAY_FILTER_USE_KEY);

// creates controller depending on the request
$controller = new $parameters['_controller']($parameters, $arguments);
