<?php
// routing with symfony
// ::class		returns fully qualified classname
const CONTROLLER = '_controller';

return [
	[
		'path' => '/blog/{slug}',
		'controller' => [CONTROLLER => \Controller\BlogController::class],
		'name' => 'blog_show'
	],
	[
		'path' => '/demo/index',
		'controller' => [CONTROLLER => \Controller\DemoController::class],
		'name' => 'route'
	],
	[
		'path' => '/retro/{slug}',
		'controller' => [CONTROLLER => \Controller\RetroController::class],
		'name' => 'serialization'
	],
	[
		'path' => '/readUsers',
		'controller' => [CONTROLLER => \Controller\UserController::class],
		'name' => 'readUsers'
	],
	[
		'path' => '/readUser/{id}',
		'controller' => [CONTROLLER => \Controller\UserController::class],
		'name' => 'readUser'
	],
	[
		'path' => '/createUser',
		'controller' => [CONTROLLER => \Controller\UserController::class],
		'name' => 'createUser'
	],
	[
		'path' => '/create-user-form',
		'controller' => [CONTROLLER => \Controller\UserController::class],
		'name' => 'createUserForm'
	],
	[
		'path' => '/updateUser/{id}/{username}/{password}',
		'controller' => [CONTROLLER => \Controller\UserController::class],
		'name' => 'updateUser'
	],
	[
		'path' => '/deleteUser/{id}',
		'controller' => [CONTROLLER => \Controller\UserController::class],
		'name' => 'deleteUser'
	],
	[
		'path' => '/readUserWhereUsernameLike/{search}',
		'controller' => [CONTROLLER => \Controller\UserController::class],
		'name' => 'readUserWhereUsernameLike'
	],
	[
		'path' => '/display/{id}',
		'controller' => [CONTROLLER => \Controller\UserController::class],
		'name' => 'display'
	],
	[
		'path' => '/orm',
		'controller' => [CONTROLLER => \Controller\UserController::class],
		'name' => 'orm'
	],
	[
		'path' => '/home',
		'controller' => [CONTROLLER => \Controller\WebsiteController::class],
		'name' => 'home'
	]
];
