<?php

namespace Mecado\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator;

class UserController extends BaseController
{

    public function registrationForm(RequestInterface $request, ResponseInterface $response, $args)
    {
        $this->render($response, 'user/register');
    }

    public function registration(RequestInterface $request, ResponseInterface $response, $args)
    {
        if (false === $request->getAttribute('csrf_status')) {
            $this->flash('error', 'Une erreur est survenue pendant l\'envoi du formulaire !');
            return $this->redirect($response, 'user.register.form', $request->getParams());
        } else {

            $errors = [];

            if (!Validator::stringType()->notEmpty()->validate($request->getParam('first_name'))) {
                $errors['first_name'] = "Veuillez saisir un prénom valide.";
            }

            if (!Validator::stringType()->notEmpty()->validate($request->getParam('last_name'))) {
                $errors['last_name'] = "Veuillez saisir un nom valide.";
            }

            if (!Validator::email()->validate($request->getParam('email'))) {
                $errors['email'] = "Veuillez saisir un email valide.";
            }

            if (!Validator::stringType()->notEmpty()->validate($request->getParam('password'))) {
                $errors['password'] = "Veuillez saisir un mot de passe valide.";
            }

            if (!Validator::stringType()->notEmpty()->validate($request->getParam('password_repeat'))) {
                $errors['password_repeat'] = "Veuillez saisir un mot de passe de vérification valide.";
            }

            if (strcmp($request->getParam('password'), $request->getParam('password_repeat')) != 0) {
                $errors['password'] = "Le mot de passe ne correspond pas au mot de passe de vérification.";
            }

            if (strcmp($request->getParam('password_repeat'), $request->getParam('password')) != 0) {
                $errors['password'] = "Le mot de passe de vérification ne correspond pas au mot de passe.";
            }

            if (empty($errors)) {

            } else {
                $this->flash('errors', $errors);
                return $this->redirect($response, 'user.register.form', $args, 400);
            }
        }
    }

}