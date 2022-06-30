<?php

namespace Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller
{
    protected Environment $twig;

    public function __construct(array $parameters, array $arguments)
    {
        $twigLoader = new FilesystemLoader(dirname(__DIR__) . '/views/templates/');

//		with cache
//		$this->twig = new Environment($twigLoader, ['cache' => dirname(__DIR__, 3) . '/cache']);

//		without cache
        $this->twig = new Environment($twigLoader, ['cache' => false]);

        // function call
        call_user_func_array(array($this, $parameters['_route']), $arguments);
    }
}
