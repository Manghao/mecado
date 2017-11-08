<?php

namespace Mecado\Controllers;

use Mecado\Models\Liste;
use Mecado\Models\Product;
use Mecado\Utils\Session;
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
        $liste = new Liste();
        $liste->name=$request->getParam('list_title');
        $liste->descr=$request->getParam('description');
        $liste->dateExp=$request->getParam('end_date');
        $liste->other_dest=is_null($request->getParam('other_dest')) ? 0 : 1;

        //TMP
        $liste->id_creator=66;
        $liste->save();

        return $this->redirect($response, 'list.listitems', ['id' => $liste->id]);

      } else {
          $this->flash('errors', $errors);
          return $this->redirect($response, 'user.register.form', $args);
      }
    }
  }

  public function createproductForm(RequestInterface $request, ResponseInterface $response, $args)
  {
    $this->render($response, 'list/createproduct');
  }

  public function createproduct(RequestInterface $request, ResponseInterface $response, $args)
  {
    if (false === $request->getAttribute('csrf_status')) {
      $this->flash('error', 'Une erreur est survenue pendant l\'envoi du formulaire !');
      return $this->redirect($response, 'list.createproduct.form', $request->getparams());
    } else {

      $errors = [];

      if (!Validator::stringType()->notEmpty()->validate($request->getParam('name'))) {
        $errors['name'] = "Veuillez saisir un nom valide.";
      }

      if (!Validator::stringType()->notEmpty()->validate($request->getParam('description'))) {
        $errors['description'] = "Veuillez saisir une descritpion valide.";
      }

      if (!Validator::url()->validate($request->getParam('link'))) {
        $errors['link'] = "Veuillez saisir un lien valide.";
      }

      if (!Validator::floatval()->notEmpty()->validate($request->getParam('price'))) {
        $errors['price'] = "Veuillez saisir un lien valide.";
      }
      if (!Validator::notEmpty()->validate($request->getParam('pic'))) {
        $errors['pic'] = "Veuillez ajouter un fichier valide.";
      }


      if (empty($errors)) {
        $liste = new Liste();
        $liste->name=$request->getParam('list_title');
        $liste->descr=$request->getParam('description');
        $liste->dateExp=date('Y-m-d H:i:s', strtotime($request->getParam('end_date')));
        $liste->other_dest=is_null($request->getParam('other_dest')) ? 0 : 1;

        //TMP
        $liste->id_creator=Session::get('user')->id;
        $liste->save();

        return $this->redirect($response, 'list.listitems', ['id' => $liste->id]);

      } else {
          $this->flash('errors', $errors);
          return $this->redirect($response, 'user.register.form', $args);
      }
    }
  }

  public function listitems(RequestInterface $request, ResponseInterface $response, $args) {
      $list = Liste::where('id', '=', $args['id'])
          ->first();

      if (!empty($list)) {
          $products = Product::get();

          if (!empty($products)) {
              $this->render($response, 'list/listitems', [
                  'list' => $list,
                  'products' => $products], $args);
          } else {
              return $this->redirect($response, 'index');
          }
      } else {
          return $this->redirect($response, 'index');
      }
  }
}
