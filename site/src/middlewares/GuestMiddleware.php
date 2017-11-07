<?php

namespace mecado\middlewares;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use mecado\utils\Session;
use mecado\utils\Utils;

/**
 * Middleware de gestion connexion visiteur
 * Class GuestMiddleware
 * @package mecado\middlewares
 */
class GuestMiddleware
{

    private $container;

    /**
     * GuestMiddleware constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Fonction d'invocation du middleware
     * @param RequestInterface $request
     * @param RequestInterface $response
     * @param $next
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, $next)
    {
        if(!Session::isLogged('user')) {
            return $next($request, $response);
        } else {
            return $response->withStatus(302)->withHeader('Location', $this->container->get('router')->pathFor('user.view', ['name' => Session::get('user')->name]));
        }
    }
    
}
