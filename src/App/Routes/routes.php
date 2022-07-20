<?php

use Controller\BlogController;
use Controller\DemoController;
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
		'path' => '/readUsers',
		'controller' => [CONTROLLER => UserController::class],
		'name' => 'readUsers'
	],
	[
		'path' => '/readUser/{id}',
		'controller' => [CONTROLLER => UserController::class],
		'name' => 'readUser'
	],
	[
		'path' => '/createUser',
		'controller' => [CONTROLLER => UserController::class],
		'name' => 'createUser'
	],
	[
		'path' => '/create-user-form',
		'controller' => [CONTROLLER => UserController::class],
		'name' => 'createUserForm'
	],
	[
		'path' => '/updateUser/{id}/{username}/{password}',
		'controller' => [CONTROLLER => UserController::class],
		'name' => 'updateUser'
	],
	[
		'path' => '/deleteUser',
		'controller' => [CONTROLLER => UserController::class],
		'name' => 'deleteUser'
	],
	[
		'path' => '/readUserWhereUsernameLike/{search}',
		'controller' => [CONTROLLER => UserController::class],
		'name' => 'readUserWhereUsernameLike'
	],
	[
		'path' => '/profile',
		'controller' => [CONTROLLER => UserController::class],
		'name' => 'displayProfile'
	],
	[
		'path' => '/orm',
		'controller' => [CONTROLLER => UserController::class],
		'name' => 'orm'
	],
	[
		'path' => '/home',
		'controller' => [CONTROLLER => WebsiteController::class],
		'name' => 'home'
	],
    [
        'path' => '/login-form',
        'controller' => [CONTROLLER => LoginController::class],
        'name' => 'loginForm'
    ],
    [
        'path' => '/login',
        'controller' => [CONTROLLER => LoginController::class],
        'name' => 'login'
    ],
    [
        'path' => '/logout',
        'controller' => [CONTROLLER => LoginController::class],
        'name' => 'logout'
    ]
];
