<?php

namespace Mecado\Middlewares;

use Slim\Csrf\Guard;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Middleware de CSRF
 * Class CsrfMiddleware
 * @package Mecado\Middlewares
 */
class CsrfMiddleware
{

    private $twig;
    private $csrf;

    /**
     * CsrfMiddleware constructor.
     * @param \Twig_Environment $twig
     * @param Guard $csrf
     */
    public function __construct(\Twig_Environment $twig, Guard $csrf)
    {
        $this->twig = $twig;
        $this->csrf = $csrf;
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
        $csrf = $this->csrf;
        $this->twig->addFunction(new \Twig_SimpleFunction('csrf', function() use ($request, $csrf) {
            $nameKey = $csrf->getTokenNameKey();
            $valueKey = $csrf->getTokenValueKey();
            $name = $request->getAttribute($nameKey);
            $value = $request->getAttribute($valueKey);
            return '<input type="hidden" name="' . $nameKey .'" value="'. $name .'"><input type="hidden" name="' . $valueKey .'" value="' . $value .'">';
        }, ['is_safe' => ['html']]));
        return $next($request, $response);
    }

}
