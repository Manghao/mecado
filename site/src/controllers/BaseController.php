<?php

namespace mecado\controllers;

use Psr\Http\Message\ResponseInterface;
use mecado\utils\Session;

/**
 * Class BaseController
 * Classe parent des controllers
 * @package mecado\controllers
 */
class BaseController
{

    private $container;

    /**
     * BaseController constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Fonction de rendu de vue
     * @param ResponseInterface $response
     * @param $view
     * @param array $params
     */
    public function render(ResponseInterface $response, $view, $params = array())
    {
        $this->container->views->render($response, $view . '.html.twig', $params);
    }

    /**
     * Fonction de rendu jSON
     * @param ResponseInterface $response
     * @param $name
     * @param array $params
     * @param int $status
     * @return static
     */
    public function json(ResponseInterface $response, $data)
    {
        return $response->withHeader('Content-type', 'application/json')->withJson($data, 201);
    }

    /**
     * Fonction de redirection
     * @param ResponseInterface $response
     * @param $name
     * @param array $params
     * @param int $status
     * @return static
     */
    public function redirect(ResponseInterface $response, $name, $params = array(), $status = 302)
    {
        return $response->withStatus($status)->withHeader('Location', $this->container->get('router')->pathFor($name, (!is_null($params) ? $params : [])));
    }

    /**
     * Fonction qui genere des messages flas
     * @param $type
     * @param $message
     */
    public function flash($type, $message)
    {
        if (Session::exist('flash')) {
            Session::set('flash', []);
        }
        Session::set('flash', [$type => $message]);
    }

    /**
     * Getter d'attributs
     * @param $name
     * @return mixed
     */
    public function __get($name) {
        return $this->$name;
    }

}
