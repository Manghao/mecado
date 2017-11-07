<?php

namespace mecado\middlewares;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Permet de récuperer des valeurs dans les fichiers de configurations
 * Class PickerMiddleware
 * @package mecado\middlewares
 */
class PickerMiddleware
{

    private $twig;

    /**
     * PickerMiddleware constructor.
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
        $this->twig->addFunction(new \Twig_SimpleFunction('picker', function($var) use ($request) {
            $datas = array();
            $vars = explode('.', $var);
            $p = SRC . DS . 'conf' . DS . $vars[0] . '.conf.php';
            if (file_exists($p)) {
                $datas = require $p;
                if (array_key_exists($vars[1], $datas)) {
                    return $datas[$vars[1]];
                } else {
                    return "VARIABLE_NOT_FOUND";
                }
            } else {
                return "VARIABLE_NOT_FOUND";
            }
        }, ['is_safe' => ['html']]));
        return $next($request, $response);
    }

}
