<?php

namespace Mecado\Controllers;

use Mecado\Models\Liste;
use Mecado\Models\ListProducts;
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
        $liste->dateExp=date('Y-m-d H:i:s', strtotime($request->getParam('end_date')));
        $liste->other_dest=$request->getParam('other_dest') === 'on' ? 1 : 0;

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

      if (!is_null($list)) {
          $products = Products::get();

          if (!is_null($products)) {
              $this->render($response, 'list/listitems', [
                  'list' => $list,
                  'products' => $products]);
          } else {
              $this->flash('error', 'Les produits n\'existent pas');
              return $this->redirect($response, 'index');
          }
      } else {
          $this->flash('error', 'La liste n\'existe pas');
          return $this->redirect($response, 'index');
      }
  }

  public function additem(RequestInterface $request, ResponseInterface $response, $args) {
      $list = Liste::where('id', '=', $args['id'])
          ->first();

      if (!is_null($list)) {
          $product = Product::where('id', '=', $args['idProd'])
              ->first();

          if (!is_null($product)) {
              $list_product = new ListProducts();
              $list_product->id_list = $list->id;
              $list_product->id_prod = $product->id;
              $list_product->save();

              return $this->redirect($response, 'list.listitems', ['id' => $list->id]);
          } else {
              $this->flash('error', 'Le produit n\'existe pas');
              return $this->redirect($response, 'index');
          }
      } else {
          $this->flash('error', 'La liste n\'existe pas');
          return $this->redirect($response, 'index');
      }
  }
}
