<?php

namespace Handler;

use Twig\Environment;
use Twig\Error\Error;
use Twig\Loader\FilesystemLoader;

class TwigHandler
{
    private Environment $twig;
    private static ?TwigHandler $twigHandler = null;

    public function __construct()
    {
        $twigLoader = new FilesystemLoader(dirname(__DIR__) . '/views/templates/');

//		with cache
//		$this->twig = new Environment($twigLoader, ['cache' => dirname(__DIR__, 3) . '/cache']);

//		without cache
        $this->twig = new Environment($twigLoader, ['cache' => false]);
    }

    public static function getTwigHandler(): TwigHandler
    {
        if (self::$twigHandler === null) {
            self::$twigHandler = new TwigHandler();
        }
        return self::$twigHandler;
    }

    public function renderTwigTemplate(string $template, array $payload): void
    {
        try {
            echo $this->twig->render($template, $payload);
        }catch (Error $e){
            echo $e->getMessage();
        }
    }
}
