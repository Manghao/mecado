<?php

namespace Mecado\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AppController extends BaseController
{

    public function index(RequestInterface $request, ResponseInterface $response, $args)
    {

        $this->render($response, 'app/index');
    }

}
