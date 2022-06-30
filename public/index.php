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

// session handling einfügen

// get routes from extern file
$routeSource = require_once __DIR__ . "/../src/App/Routes/routes.php";

// stores a combination of path and route
$routes = new RouteCollection();

foreach ($routeSource as $item) {
	$route = new Route($item['path'], $item['controller']);
	$routes->add($item['name'], $route);
}

$context = new RequestContext('', $_SERVER['REQUEST_METHOD'], $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_SCHEME'], 80, 8099, str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']), $_SERVER['QUERY_STRING']);

$matcher = new UrlMatcher($routes, $context);
$parameters = $matcher->match($context->getPathInfo());
switch($context->getMethod()) {
	case 'GET':
		if(!empty($_GET)) {
			$parameters['payload'] = $_GET;
		}
		break;
	case "POST":
		if(!empty($_POST)) {
			$parameters['payload'] = $_POST;
		}
		break;
	case "UPGRADE":
		$payload = file_get_contents('php://input');
		var_dump($payload);
		break;
	default:
		break;
}

$arguments = array_filter($parameters, function ($index) {
	return ($index != '_controller' && $index != '_route');
}, ARRAY_FILTER_USE_KEY);
// creates controller depending on the request
$controller = new $parameters['_controller']($parameters, $arguments);
