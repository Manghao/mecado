<?php

namespace mecado\controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AppController extends BaseController
{

    public function index(RequestInterface $request, ResponseInterface $response, $args)
    {
        var_dump("ON");
    }

}
