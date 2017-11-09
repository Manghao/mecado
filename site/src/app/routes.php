<?php

use Mecado\Controllers\AppController;
use Mecado\Controllers\ProductController;
use Mecado\Controllers\UserController;
use Mecado\Controllers\ListController;
use Mecado\Middlewares\GuestMiddleware;
use Mecado\Middlewares\AuthMiddleware;

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

    $this->get('/login', UserController::class . ':loginForm')
        ->add(new GuestMiddleware($container))
        ->setName('user.login.form');

    $this->post('/login', UserController::class . ':login')
        ->add(new GuestMiddleware($container))
        ->setName('user.login');

    $this->get('/view', UserController::class . ':view')
        ->add(new AuthMiddleware($container))
        ->setName('user.view');

    $this->get('/logout', UserController::class . ':logout')
        ->add(new AuthMiddleware($container))
        ->setName('user.logout');

});

$app->group('/list', function() {
   $container = $this->getContainer();

    $this->get('/creationlist', ListController::class . ':creationlistForm')
        ->add(new AuthMiddleware($container))
        ->setName('list.creationlist.form');

    $this->post('/creationlist', ListController::class . ':creationlist')
        ->add(new AuthMiddleware($container))
        ->setName('list.creationlist');

    $this->get('/{id:[0-9]+}/listitems', ListController::class . ':listitems')
        ->add(new AuthMiddleware($container))
        ->setName('list.listitems');

    $this->get('/{id:[0-9]+}/additem/{idProd:[0-9]+}', ListController::class . ':additem')
        ->add(new AuthMiddleware($container))
        ->setName('list.additem');

    $this->get('/{id:[0-9]+}/createproduct', ListController::class . ':createproductForm')
          ->add(new AuthMiddleware($container))
          ->setName('list.createproduct.form');

    $this->post('/{id:[0-9]+}/createproduct', ListController::class . ':createproduct')
        ->add(new AuthMiddleware($container))
        ->setName('list.createproduct');

    $this->get('/view/{id:[0-9]+}', ListController::class . ':view')
        ->setName('list.view');

    $this->get('/share/{id:[0-9]+}', ListController::class . ':share')
        ->setName('list.share');

    $this->get('/{token:[0-9]+}', ListController::class . ':share')
        ->setName('list.view.shared');
});

$app->group('/products', function() {
   $container = $this->getContainer();

   $this->get('[/]', ProductController::class . ':products')
       ->setName('product.products');
});
