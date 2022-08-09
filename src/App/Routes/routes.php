<?php

use Controller\BlogController;
use Controller\DemoController;
use Controller\HomeController;
use Controller\RetroController;
use Controller\UserController;
use Controller\WebsiteController;
use Controller\LoginController;


// routing with symfony
// ::class		returns fully qualified classname
const CONTROLLER = '_controller';

return [
	[
		'path' => '/blog/{slug}',
		'controller' => [CONTROLLER => BlogController::class],
		'name' => 'blog_show'
	],
	[
		'path' => '/demo/index',
		'controller' => [CONTROLLER => DemoController::class],
		'name' => 'route'
	],
	[
		'path' => '/retro/{slug}',
		'controller' => [CONTROLLER => RetroController::class],
		'name' => 'serialization'
	],
	[
		'path' => '/harambe',
		'controller' => [CONTROLLER => WebsiteController::class],
		'name' => 'home'
	],
//    show-application
    [
        'path' => '/login',
        'controller' => [CONTROLLER => LoginController::class],
        'name' => 'renderLoginForm'
    ],
    [
        'path' => '/logging-in',
        'controller' => [CONTROLLER => LoginController::class],
        'name' => 'loggingIn'
    ],
    [
        'path' => '/logout',
        'controller' => [CONTROLLER => LoginController::class],
        'name' => 'logout'
    ],
    [
        'path' => '/home',
        'controller' => [CONTROLLER => HomeController::class],
        'name' => 'home'
    ],
    [
        'path' => '/user',
        'controller' => [CONTROLLER => UserController::class],
        'name' => 'displayUser'
    ],
    [
        'path' => '/signup',
        'controller' => [CONTROLLER => UserController::class],
        'name' => 'renderSignupForm'
    ],
    [
        'path' => '/createUser',
        'controller' => [CONTROLLER => UserController::class],
        'name' => 'createUser'
    ],
];
