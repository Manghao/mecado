<?php

namespace mecado\middlewares;

use Slim\Http\Request;
use Slim\Http\Response;
use mecado\utils\Session;

/**
 * Middleware de gestion connexion
 * Class AuthTwigMiddleware
 * @package mecado\middlewares
 */
class AuthTwigMiddleware
{

    private $twig;

    /**
     * AuthMiddleware constructor.
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
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        $this->twig->addGlobal('auth', Session::isLogged('user') ?  Session::get('user') : []);
        return $next($request, $response);
    }

}
