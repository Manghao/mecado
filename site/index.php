<?php

use Mecado\DatabaseFactory;
use Mecado\Middlewares\AssetsTwigMiddleware;
use Mecado\Middlewares\AuthMiddleware;
use Mecado\Middlewares\AuthTwigMiddleware;
use Mecado\Middlewares\CsrfMiddleware;
use Mecado\Middlewares\FlashMiddleware;
use Mecado\Middlewares\GuestMiddleware;
use Mecado\Middlewares\PersistentValuesMiddleware;
use Mecado\Middlewares\PickerMiddleware;
use Mecado\Utils\Session;
use Mecado\Controllers\AppController;

// Importation de l'autoloader
require 'vendor/autoload.php';

// Demarrage de la session
Session::initSession();

// Definition de la timezone
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

// Variables globales
define('DS', DIRECTORY_SEPARATOR);
define('SRC', dirname(basename(__DIR__)) . DS . 'src');
define('ASSETS', dirname(basename(__DIR__)) . DS . 'assets');
define('UPLOADS', ASSETS . DS . 'uploads');

// Configuration de la connexion a la base de donnees
DatabaseFactory::setConfig();
DatabaseFactory::makeConnection();

// Initialisation de Slim
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => ((\Mecado\Utils\Picker::get('app.env') === 'dev') ? true : false) // Affichage des erreurs
    ]
]);

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

// Redefinition de la page d'erreur 404
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container->views->render($response, 'errors/404.html.twig');
    };
};

// Ajouts du Middleware de messages flash
$app->add(new FlashMiddleware($container->views->getEnvironment()));

// Ajouts du Middleware de valeurs persistantes dans les fomulaires
$app->add(new PersistentValuesMiddleware($container->views->getEnvironment()));

// Ajouts du Middleware de recuperation d'assets
$app->add(new AssetsTwigMiddleware($container->views->getEnvironment()));

// Ajouts du Middleware de recuperation de variable dans des fichiers de configuration
$app->add(new PickerMiddleware($container->views->getEnvironment()));

// Ajouts du Middleware de gestion de la connexion
$app->add(new AuthTwigMiddleware($container->views->getEnvironment()));

// Ajouts du Middleware de protection csrf
$app->add(new CsrfMiddleware($container->views->getEnvironment(), $container->csrf));
$app->add($container->get('csrf'));

// Routes
$app->get('/', AppController::class . ':index')
    ->setName('index');


$app->run();
