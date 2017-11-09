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
                $liste->date_exp=date('Y-m-d H:i:s', strtotime($request->getParam('end_date')));
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
                $liste->date_exp=date('Y-m-d H:i:s', strtotime($request->getParam('end_date')));
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

        if (!is_null($list)) {
            $products = Product::whereNotIn('id', function($query) {
                $query->select('id_prod')
                    ->from('list_products');
            })->get();

            if (!is_null($products)) {
                $this->render($response, 'list/listitems', [
                    'list' => $list,
                    'products' => $products]);
            } else {
                $this->flash('error', 'Les produits n\'existent pas !');
                return $this->redirect($response, 'index');
            }
        } else {
            $this->flash('error', 'La liste n\'existe pas !');
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
                $list_product = ListProducts::where('id_list', '=', $list->id)
                    ->where('id_prod', '=', $product->id)
                    ->first();

                if (is_null($list_product)) {
                    $list_product = new ListProducts();
                    $list_product->id_list = $list->id;
                    $list_product->id_prod = $product->id;
                    $list_product->save();

                    $this->flash('success', 'Le produit "' . $product->name . '" a bien été ajouté à votre liste !');
                    return $this->redirect($response, 'list.listitems', ['id' => $list->id]);
                } else {
                    $this->flash('error', 'Le produit a déjà été ajouté à la liste !');
                    return $this->redirect($response, 'list.listitems', ['id' => $list->id]);
                }
            } else {
                $this->flash('error', 'Le produit n\'existe pas !');
                return $this->redirect($response, 'index');
            }
        } else {
            $this->flash('error', 'La liste n\'existe pas !');
            return $this->redirect($response, 'index');
        }
    }
  
    public function view(RequestInterface $request, ResponseInterface $response, $args)
  {
        $list = Liste::where('id', '=', $args['id'])->first();
        if (!is_null($list)) {
            $this->render($response, 'list/view', ['list' => $list]);
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuveable.');
            return $this->redirect($response, 'index');
        }
    }

    public function share(RequestInterface $request, ResponseInterface $response, $args)
    {
        $list = Liste::where('id', '=', $args['id'])->first();
        if (!is_null($list)) {
            $url = $_SERVER['REQUEST_SCHEME'] . '://';
            $url .= $_SERVER['HTTP_HOST'];
            $url .= $this->container->get('router')
                        ->pathFor('list.view.shared', [
                            'token' => uniqid()
                        ]);

            $list->url_share = $url;
            $list->save();

            $this->flash('success', 'URL de partage : ' . $url);
            return $this->redirect($response, 'list.view', ['id' => $list->id]);
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuveable.');
            return $this->redirect($response, 'index');
        }
    }
}