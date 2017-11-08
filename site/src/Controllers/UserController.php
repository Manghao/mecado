<?php

namespace Mecado\Controllers;

use Mecado\Models\User;
use Mecado\Utils\Session;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator;

class UserController extends BaseController
{

    public function registrationForm(RequestInterface $request, ResponseInterface $response)
    {
        $this->render($response, 'user/register');
    }

    public function registration(RequestInterface $request, ResponseInterface $response)
    {
        if (false === $request->getAttribute('csrf_status')) {
            $this->flash('error', 'Une erreur est survenue pendant l\'envoi du formulaire !');
            return $this->redirect($response, 'user.register.form', []);
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

            if ($request->getParam('password') !== $request->getParam('password_repeat')) {
                $errors['password'] = "Le mot de passe ne correspond pas au mot de passe de vérification.";
            }

            if ($request->getParam('password_repeat') !== $request->getParam('password')) {
                $errors['password_repeat'] = "Le mot de passe de vérification ne correspond pas au mot de passe.";
            }

            if (empty($errors)) {
                User::create([
                   'last_name' => $request->getParam('last_name'),
                   'first_name' => $request->getParam('first_name'),
                   'mail' => $request->getParam('email'),
                   'password' => password_hash($request->getParam('password'), PASSWORD_BCRYPT)
                ]);

                $this->flash('success', "Inscription réussie avec succès.");
                return $this->redirect($response, 'index');
            } else {
                $this->flash('errors', $errors);
                return $this->redirect($response, 'user.register.form', []);
            }
        }
    }

    public function loginForm(RequestInterface $request, ResponseInterface $response)
    {
        $this->render($response, 'user/login');
    }

    public function login(RequestInterface $request, ResponseInterface $response)
    {
        if (false === $request->getAttribute('csrf_status')) {
            $this->flash('error', 'Une erreur est survenue pendant l\'envoi du formulaire !');
            return $this->redirect($response, 'user.login.form', []);
        } else {

            $errors = [];


            if (!Validator::email()->validate($request->getParam('email'))) {
                $errors['email'] = "Veuillez saisir un email valide.";
            }

            if (!Validator::stringType()->notEmpty()->validate($request->getParam('password'))) {
                $errors['password'] = "Veuillez saisir un mot de passe valide.";
            }

            if (empty($errors)) {
                $user = User::where('mail', '=', $request->getParam('email'))->first();
                if (!is_null($user)) {
                    if (password_verify($request->getParam('password'), $user->password)) {
                        Session::set('user', $user);
                        $this->flash('success', "Connexion réussie avec succès.");
                        return $this->redirect($response, 'user.view');
                    } else {
                        $this->flash('error', "Mot de passe incorrecte");
                        return $this->redirect($response, 'user.login.form', []);
                    }
                } else {
                    $this->flash('error', "Adresse email ou mot de passe incorrecte");
                    return $this->redirect($response, 'user.login.form', []);
                }
            } else {
                $this->flash('errors', $errors);
                return $this->redirect($response, 'user.login.form', []);
            }
        }
    }

    public function view(RequestInterface $request, ResponseInterface $response)
    {
        $this->render($response, 'user/view');
    }

    public function logout(RequestInterface $request, ResponseInterface $response)
    {
        Session::unset('user');
        return $this->redirect($response, 'user.login.form');
    }

}