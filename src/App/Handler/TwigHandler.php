<?php

namespace Handler;

use Twig\Loader\FilesystemLoader;

class TwigHandler
{
    private static Environment $twig;
    private static ?TwigHandler $twigHandler = null;

    public function __construct()
    {
        $twigLoader = new FilesystemLoader(dirname(__DIR__) . '/views/templates/');

//		with cache
//		$this->twig = new Environment($twigLoader, ['cache' => dirname(__DIR__, 3) . '/cache']);

//		without cache
        self::$twig = new Environment($twigLoader, ['cache' => false]);
    }

    public static function getTwigHandler(): TwigHandler
    {
        if (self::$twigHandler === null) {
            self::$twigHandler = new TwigHandler();
        }
        return self::$twigHandler;
    }

    /**
     * @throws Error\RuntimeError
     * @throws Error\SyntaxError
     * @throws Error\LoaderError
     */
    public static function renderTwigTemplate(string $template, array $payload): void
    {
        echo self::$twig->render($template, $payload);
    }
}

// twig handler is now used in SessionHandler
// controllers still use the twig instance if their parent class