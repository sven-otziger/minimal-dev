<?php

use Controller\BlogController;
use Controller\DemoController;
use Controller\HomeController;
use Controller\MovieController;
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
        'path' => '/profile',
        'controller' => [CONTROLLER => UserController::class],
        'name' => 'displayProfile'
    ],
    [
        'path' => '/profile/{id}',
        'controller' => [CONTROLLER => UserController::class],
        'name' => 'displayForeignProfile'
    ],
    [
        'path' => '/overview',
        'controller' => [CONTROLLER => UserController::class],
        'name' => 'displayAllProfiles'
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
    [
        'path' => '/edit',
        'controller' => [CONTROLLER => UserController::class],
        'name' => 'renderUpdateForm'
    ],
    [
        'path' => '/update',
        'controller' => [CONTROLLER => UserController::class],
        'name' => 'updateUser'
    ],
    [
        'path' => '/delete',
        'controller' => [CONTROLLER => UserController::class],
        'name' => 'deleteUser'
    ],
    // movies
    [
        'path' => '/movies',
        'controller' => [CONTROLLER => MovieController::class],
        'name' => 'showAllMovies'
    ],
    [
        'path' => '/movie/edit',
        'controller' => [CONTROLLER => MovieController::class],
        'name' => 'renderEditTemplate'
    ],
    [
        'path' => '/movie/update',
        'controller' => [CONTROLLER => MovieController::class],
        'name' => 'updateMovie'
    ],
    [
        'path' => '/movie/delete',
        'controller' => [CONTROLLER => MovieController::class],
        'name' => 'deleteMovie'
    ],
    [
        // keep route below other /movie/xy routes
        'path' => '/movie/{id}',
        'controller' => [CONTROLLER => MovieController::class],
        'name' => 'showMovie'
    ]

];
