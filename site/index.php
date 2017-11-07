<?php

use mecado\DatabaseFactory;
use mecado\middlewares\AuthMiddleware;
use mecado\middlewares\AuthTwigMiddleware;
use mecado\middlewares\CsrfMiddleware;
use mecado\middlewares\FlashMiddleware;
use mecado\middlewares\GuestMiddleware;
use mecado\middlewares\PersistentValuesMiddleware;
use mecado\middlewares\PickerMiddleware;
use mecado\utils\Session;
use mecado\controllers\AppController;

// Importation de l'autoloader
require 'vendor/autoload.php';

// Demarrage de la session
Session::initSession();

// Definition de la timezone
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');

// Variables globales
define('DS', DIRECTORY_SEPARATOR);
define('SRC', __DIR__ . DS . 'src');
define('UPLOADS', __DIR__ . DS . 'assets' . DS . 'uploads');

// Configuration de la connexion a la base de donnees
DatabaseFactory::setConfig();
DatabaseFactory::makeConnection();

// Initialisation de Slim
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true // Affichage des erreurs
    ]
]);

// Initialisation du container
$container = $app->getContainer();

// Initialisation des vues dans le container
$container['views'] = function ($container) {
    $view = new \Slim\Views\Twig(SRC . DS . 'views', [
        'cache' => false // Pas de cache sur les vues
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
    return new Slim\Csrf\Guard();
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

// Ajouts du Middleware de recuperation de variable dans des fichiers de configuration
$app->add(new PickerMiddleware($container->views->getEnvironment()));

// Ajouts du Middleware de gestion de la connexion
$app->add(new AuthTwigMiddleware($container->views->getEnvironment()));

// Ajouts du Middleware de protection csrf
$app->add(new CsrfMiddleware($container->views->getEnvironment(), $container->csrf));
$app->add($container->get('csrf'));

// Routes
$app->get('/', AppController::class . ':index')->setName('index');


$app->run();
