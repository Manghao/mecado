<?php

namespace Mecado\Middlewares;

use Mecado\Models\Message;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Permet de récuperer le message d'un produit d'une liste
 * Class ProductMessageMiddleware
 * @package Mecado\Middlewares
 */
class ProductMessageMiddleware
{

    private $twig;

    /**
     * ProductMessageMiddleware constructor.
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
        $this->twig->addFunction(new \Twig_SimpleFunction('message', function($var) use ($request) {
            return Message::where('id_list_products', '=', $var)->first();
        }, ['is_safe' => ['html']]));
        return $next($request, $response);
    }

}
