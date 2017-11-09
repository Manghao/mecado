<?php

use Mecado\Middlewares\AuthTwigMiddleware;
use Mecado\Middlewares\CsrfMiddleware;
use Mecado\Middlewares\FlashMiddleware;
use Mecado\Middlewares\PersistentValuesMiddleware;
use Mecado\Middlewares\PickerMiddleware;
use Mecado\Middlewares\ProductMessageMiddleware;

// Ajouts du Middleware de messages flash
$app->add(new FlashMiddleware($container->views->getEnvironment()));

// Ajouts du Middleware de valeurs persistantes dans les fomulaires
$app->add(new PersistentValuesMiddleware($container->views->getEnvironment()));

// Ajouts du Middleware de recuperation de variable dans des fichiers de configuration
$app->add(new PickerMiddleware($container->views->getEnvironment()));

// Ajouts du Middleware de gestion de la connexion
$app->add(new AuthTwigMiddleware($container->views->getEnvironment()));

// Ajouts du Middleware de message d'un produit d'une liste
$app->add(new ProductMessageMiddleware($container->views->getEnvironment()));

// Ajouts du Middleware de protection csrf
$app->add(new CsrfMiddleware($container->views->getEnvironment(), $container->csrf));
$app->add($container->get('csrf'));
