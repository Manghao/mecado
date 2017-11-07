<?php

namespace Mecado\Middlewares;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Middleware de recuperation d'assets
 * Class AssetsTwitMiddleware
 * @package Mecado\Middlewares
 */
class AssetsTwigMiddleware
{

    private $twig;

    /**
     * AssetsTwigMiddleware constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Fonction d'invocation du middleware
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        $this->twig->addFunction(new \Twig_SimpleFunction('assets', function($path) use ($request) {
            return ASSETS . DS . $path;
        }, ['is_safe' => ['html']]));
        return $next($request, $response);
    }

}
