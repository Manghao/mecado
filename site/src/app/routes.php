<?php

use Mecado\Controllers\AppController;
use Mecado\Controllers\UserController;
use Mecado\Controllers\ListController;
use Mecado\Middlewares\GuestMiddleware;

$app->get('/', AppController::class . ':index')
    ->setName('index');

$app->group('/user', function() {
   $container = $this->getContainer();

    $this->get('/registration', UserController::class . ':registrationForm')
        ->add(new GuestMiddleware($container))
        ->setName('user.register.form');

    $this->post('/registration', UserController::class . ':registration')
        ->add(new GuestMiddleware($container))
        ->setName('user.register');


});

$app->group('/list', function() {
   $container = $this->getContainer();

    $this->get('/creationlist', ListController::class . ':creationlistForm')
        ->add(new GuestMiddleware($container))
        ->setName('list.creationlist.form');

    $this->post('/creationlist', ListController::class . ':creationlist')
        ->add(new GuestMiddleware($container))
        ->setName('list.creationlist');

    $this->get('/{id:[0-9]+}/listitems', ListController::class . ':listitems')
        ->add(new GuestMiddleware($container))
        ->setName('list.listitems');

    $this->post('/{id:[0-9]+}/createproduct', ListController::class . ':createproduct')
        ->add(new GuestMiddleware($container))
          ->setName('list.createproduct');
});
