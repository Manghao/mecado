<?php

use Mecado\DatabaseFactory;
use Mecado\Utils\Session;

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

require SRC . DS . 'app' . DS . 'container.php';
require SRC . DS . 'app' . DS . 'handlers.php';
require SRC . DS . 'app' . DS . 'middlewares.php';
require SRC . DS . 'app' . DS . 'routes.php';

$app->run();
