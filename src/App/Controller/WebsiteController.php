<?php

namespace Controller;

use Repository\UserRepository;

class WebsiteController
{
	private UserRepository $userRepo;

	public function __construct(array $parameters, array $arguments)
	{
		$this->userRepo = new UserRepository();
		// function call
		call_user_func_array(array($this, $parameters['_route']), $arguments);
	}


}