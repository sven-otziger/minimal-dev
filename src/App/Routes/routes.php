<?php
// routing with symfony
// ::class		returns fully qualified classname
return [
	[
		'path' => '/blog/{slug}',
		'controller' => ['_controller' => \Controller\BlogController::class],
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
	],
	[
		'path' => '/readUsers',
		'controller' => ['_controller' => \Controller\UserController::class],
		'name' => 'readUsers'
	],
	[
		'path' => '/readUser/{id}',
		'controller' => ['_controller' => \Controller\UserController::class],
		'name' => 'readUser'
	],
	[
		'path' => '/createUser/{username}/{password}',
		'controller' => ['_controller' => \Controller\UserController::class],
		'name' => 'createUser'
	],
	[
		'path' => '/updateUser/{id}/{username}/{password}',
		'controller' => ['_controller' => \Controller\UserController::class],
		'name' => 'updateUser'
	],
	[
		'path' => '/deleteUser/{id}',
		'controller' => ['_controller' => \Controller\UserController::class],
		'name' => 'deleteUser'
	],
	[
		'path' => '/readUserWhereUsernameLike/{search}',
		'controller' => ['_controller' => \Controller\UserController::class],
		'name' => 'readUserWhereUsernameLike'
	],
	[
		'path' => '/display/{id}',
		'controller' => ['_controller' => \Controller\UserController::class],
		'name' => 'display'
	],
	[
		'path' => '/orm',
		'controller' => ['_controller' => \Controller\UserController::class],
		'name' => 'orm'
	],
	[
		'path' => '/home',
		'controller' => ['_controller' => \Controller\WebsiteController::class],
		'name' => 'home'
	]
];
