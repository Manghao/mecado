<?php

namespace Mecado\Controllers;

use Mecado\Models\Liste;
use Mecado\Models\Product;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator;

class ListController extends BaseController
{
  public function creationlistForm(RequestInterface $request, ResponseInterface $response, $args)
  {
    $this->render($response, 'list/listcreation');
  }

  public function creationlist(RequestInterface $request, ResponseInterface $response, $args)
  {
    if (false === $request->getAttribute('csrf_status')) {
      $this->flash('error', 'Une erreur est survenue pendant l\'envoi du formulaire !');
      return $this->redirect($response, 'list.creationlist.form', $request->getparams());
    } else {

      $errors = [];

      if (!Validator::stringType()->notEmpty()->validate($request->getParam('list_title'))) {
        $errors['list_title'] = "Veuillez saisir un titre valide.";
      }

      if (!Validator::stringType()->notEmpty()->validate($request->getParam('description'))) {
        $errors['description'] = "Veuillez saisir une descritpion valide.";
      }

      if (!Validator::notEmpty()->validate($request->getParam('end_date'))) {
        $errors['end_date'] = "Veuillez saisir une date valide.";
      }
      $dateListe = strtotime($request->getParam('end_date'));
      $date = strtotime(date('Y-m-d'));

      if ($date > $dateListe) {
        $errors['end_date'] = "Veuillez saisir une date qui n'est pas encore passée.";
      }

      if (empty($errors)) {
          return $this->redirect($response, 'list.listitems', $args);
      } else {
          $this->flash('errors', $errors);
          return $this->redirect($response, 'user.register.form', $args);
      }
    }
  }

  public function listitems(RequestInterface $request, ResponseInterface $response, $args) {
      /*var_dump($args);
      $liste = new Liste();
      $liste->name = 'test';
      $liste->id_creator = 1;
      $liste->save();*/

      // a la place de args mettre ['id' => ] dans la redirection

      $list = Liste::where('id', '=', $args['id'])
          ->first();

      if (!empty($liste)) {
          $products = Product::get();

          if (!empty($products)) {
              $this->render($response, 'list/listitems', [
                  'list' => $list,
                  'products' => $products], $args);
          } else {
              return $this->redirect($response, 'index', $args);
          }
      } else {
          return $this->redirect($response, 'index', $args);
      }
  }
}
