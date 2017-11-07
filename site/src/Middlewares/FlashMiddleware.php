<?php

namespace Mecado\Middlewares;

use Slim\Http\Request;
use Slim\Http\Response;
use Mecado\Utils\Session;

/**
 * Middleware de messages flash
 * Class FlashMiddleware
 * @package Mecado\Middlewares
 */
class FlashMiddleware
{

    private $twig;

    /**
     * FlashMiddleware constructor.
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
        $this->twig->addGlobal('flash', Session::exist('flash') ? Session::get('flash') : []);
        if (Session::exist('flash')) {
            Session::unset('flash');
        }
        return $next($request, $response);
    }

}
