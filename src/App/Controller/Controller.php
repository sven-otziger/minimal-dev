<?php

namespace Controller;

use Session\SessionHandler;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller
{
    protected Environment $twig;
    protected SessionHandler $sessionHandler;

    public function __construct(array $parameters, array $arguments)
    {
        $this->sessionHandler = SessionHandler::getSessionHandler();

        $twigLoader = new FilesystemLoader(dirname(__DIR__) . '/views/templates/');

//		with cache
//		$this->twig = new Environment($twigLoader, ['cache' => dirname(__DIR__, 3) . '/cache']);

//		without cache
        $this->twig = new Environment($twigLoader, ['cache' => false]);

        // function call
        call_user_func_array(array($this, $parameters['_route']), $arguments);
    }
}
