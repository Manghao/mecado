<?php

namespace Mecado\Middlewares;

use Mecado\Utils\Session;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Middleware de valeurs persistantes dans les formulaires
 * Class PersistentValuesMiddleware
 * @package Mecado\Middlewares
 */
class PersistentValuesMiddleware
{

    private $twig;

    /**
     * PersistentValuesMiddleware constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Fonction d'invocation du middleware
     * @param Request$request
     * @param Response $response
     * @param $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        $this->twig->addGlobal('persistValues', Session::exist('persistValues') ? Session::get('persistValues') : []);
        if (Session::exist('persistValues')) {
            Session::unset('persistValues');
        }
        $response = $next($request, $response);
        if ($response->getStatusCode() !== 200) {
            Session::set('persistValues', $request->getParams());
        }
        return $response;
    }

}
