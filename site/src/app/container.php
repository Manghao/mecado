<?php

// Initialisation du container
$container = $app->getContainer();

// Initialisation des vues dans le container
$container['views'] = function ($container) {
    $view = new \Slim\Views\Twig(SRC . DS . 'Views', [
        'cache' => ((\Mecado\Utils\Picker::get('app.env') === 'dev') ? false : 'var/cache/views') // Cache des vues
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

// Initialisation des messages flash dans le container
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

// Initialisation de la protection csrf dans le container
$container['csrf'] = function () {
    $guard =  new Slim\Csrf\Guard();
    $guard->setFailureCallable(function ($request, $response, $next) {
        $request = $request->withAttribute("csrf_status", false);
        return $next($request, $response);
    });
    return $guard;
};