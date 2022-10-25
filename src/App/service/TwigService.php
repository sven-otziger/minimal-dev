<?php

namespace Service;

use Twig\Environment;
use Twig\Error\Error;
use Twig\Loader\FilesystemLoader;

class TwigService
{
    private Environment $twig;
    private static ?TwigService $twigService = null;

    public function __construct()
    {
        $twigLoader = new FilesystemLoader(dirname(__DIR__) . '/views/templates/');

//		with cache
//		$this->twig = new Environment($twigLoader, ['cache' => dirname(__DIR__, 3) . '/cache']);

//		without cache
        $this->twig = new Environment($twigLoader, ['cache' => false]);
    }

    public static function getTwigService(): TwigService
    {
        if (self::$twigService === null) {
            self::$twigService = new TwigService();
        }
        return self::$twigService;
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
