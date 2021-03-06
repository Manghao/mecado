<?php

namespace Mecado\Controllers;

use Illuminate\Support\Facades\Response;
use Mecado\Models\Comment;
use Mecado\Models\Image;
use Mecado\Models\Liste;
use Mecado\Models\ListProducts;
use Mecado\Models\Message;
use Mecado\Models\Product;
use Mecado\Utils\Paginator;
use Mecado\Utils\Picker;
use Mecado\Utils\Session;
use Mecado\Utils\Utils;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator;
use voku\helper\AntiXSS;

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
            $antiXssTitle = new AntiXSS();
            $antiXssTitle->xss_clean($request->getParam('list_title'));

            $antiXssDescr = new AntiXSS();
            $antiXssDescr->xss_clean($request->getParam('description'));

            $antiXssEndDate = new AntiXSS();
            $antiXssEndDate->xss_clean($request->getParam('end_date'));

            $antiXssNameDest = new AntiXSS();
            $antiXssNameDest->xss_clean($request->getParam('name_dest'));

            if (!$antiXssTitle->isXssFound() && !$antiXssDescr->isXssFound() && !$antiXssEndDate->isXssFound() && !$antiXssNameDest->isXssFound()) {
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

                if (!empty($request->getParam('name_dest'))) {
                    if (!Validator::stringType()->notEmpty()->validate($request->getParam('name_dest'))) {
                        $errors['name_dest'] = "Veuillez saisir un nom valide.";
                    }
                }

                $dateListe = strtotime($request->getParam('end_date'));
                $date = strtotime(date('Y-m-d'));

                if ($date > $dateListe) {
                    $errors['end_date'] = "Veuillez saisir une date qui n'est pas encore passée.";
                }

                if (empty($errors)) {
                    $liste = new Liste();
                    $liste->name = $request->getParam('list_title');
                    $liste->descr = $request->getParam('description');
                    $liste->date_exp = date('Y-m-d H:i:s', strtotime($request->getParam('end_date')));
                    $liste->other_dest = is_null($request->getParam('other_dest')) ? 0 : 1;
                    $liste->name_dest = !empty($request->getParam('name_dest')) ? $request->getParam('name_dest') : null;
                    $liste->id_creator = Session::get('user')->id;
                    $liste->save();

                    if ($liste->other_dest == 0) {
                        setcookie('mecado_' . $liste->id, $liste->id, strtotime($request->getParam('end_date')), '/', current($request->getHeader('Host')), false, true);
                    }

                    return $this->redirect($response, 'list.listitems', ['id' => $liste->id]);

                } else {
                    $this->flash('errors', $errors);
                    return $this->redirect($response, 'list.creationlist', $args);
                }
            } else {
                $this->flash('error', 'Impossible de traiter le fomulaire !');
                return $this->redirect($response, 'list.creationlist', $args);
            }
        }
    }

    public function createproductForm(RequestInterface $request, ResponseInterface $response, $args)
    {
        $this->render($response, 'list/createproduct');
    }

    public function createproduct(RequestInterface $request, ResponseInterface $response, $args)
    {
        $list = Liste::where('id', '=', $args['id'])->first();
        if (!is_null($list)) {
            if (false === $request->getAttribute('csrf_status')) {
                $this->flash('error', 'Une erreur est survenue pendant l\'envoi du formulaire !');
                return $this->redirect($response, 'list.createproduct.form', $request->getparams());
            } else {
                $antiXssName = new AntiXSS();
                $antiXssName->xss_clean($request->getParam('name'));

                $antiXssDescr = new AntiXSS();
                $antiXssDescr->xss_clean($request->getParam('description'));

                $antiXssLink = new AntiXSS();
                $antiXssLink->xss_clean($request->getParam('link'));

                $antiXssPrice = new AntiXSS();
                $antiXssPrice->xss_clean($request->getParam('price'));

                if (!$antiXssName->isXssFound() && !$antiXssDescr->isXssFound() && !$antiXssLink->isXssFound() && !$antiXssPrice->isXssFound()) {
                    $errors = [];

                    if (!Validator::stringType()->notEmpty()->validate($request->getParam('name'))) {
                        $errors['name'] = "Veuillez saisir un nom valide.";
                    }

                    if (!Validator::stringType()->notEmpty()->validate($request->getParam('description'))) {
                        $errors['description'] = "Veuillez saisir une descritpion valide.";
                    }

                    if (!empty($request->getParam('link'))) {
                        if (!Validator::url()->validate($request->getParam('link'))) {
                            $errors['link'] = "Veuillez saisir un lien valide.";
                        }
                    }

                    if (!Validator::floatVal()->notEmpty()->validate($request->getParam('price'))) {
                        $errors['price'] = "Veuillez saisir un lien valide.";
                    }

                    if (!empty($request->getParam('pic'))) {
                        if (!Validator::image()->validate($request->getParam('pic'))) {
                            $errors['pic'] = "Veuillez ajouter un fichier valide.";
                        }
                    }

                    if (empty($errors)) {

                        $product = new Product();
                        $product->name = $request->getParam('name');
                        $product->descr = $request->getParam('description');
                        $product->url = $request->getParam('link');
                        $product->price = $request->getParam('price');
                        $product->custom_product = 1;
                        $product->save();

                        $image = new Image();
                        $image->id_prod = $product->id;

                        $file = $request->getUploadedFiles();

                        if (!empty($file)) {
                            $img = $file['pic'];
                            if ($img->getError() == UPLOAD_ERR_OK) {
                                $name = strtolower(Utils::slug($request->getParam('name')) . '_' . $img->getClientFilename());
                                $img->moveTo(UPLOAD . DS . $name);

                                $image->name = $name;
                            }
                        }

                        $image->save();

                        $this->flash('success', 'Le produit "' . $product->name . '" a bien été ajouté à votre liste !');
                        return $this->redirect($response, 'list.listitems', ['id' => $list->id]);
                    } else {
                        $this->flash('errors', $errors);
                        return $this->redirect($response, 'list.listitems', [
                            'id' => $list->id
                        ]);
                    }
                } else {
                    $this->flash('error', 'Impossible de traiter le formulaire !');
                    return $this->redirect($response, 'list.listitems', [
                        'id' => $list->id
                    ]);
                }
            }
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable !');
            return $this->redirect($response, 'index');
        }
    }

    public function listitems(RequestInterface $request, ResponseInterface $response, $args) {
        $list = Liste::where('id', '=', $args['id'])
            ->first();

        if (!is_null($list)) {
            $products = Product::whereNotIn('id', function($query) use ($list) {
                $query->select('id_prod')
                    ->from('list_products')
                    ->where('id_list', '=', $list->id);
            })->get();

            if (!is_null($products)) {
                $this->render($response, 'list/listitems', [
                    'list' => $list,
                    'products' => $products]);
            } else {
                $this->flash('error', 'Les produits demandés n\'existent pas ou sont introuvables !');
                return $this->redirect($response, 'index');
            }
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable !');
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
                $this->flash('error', 'Le produit demandé n\'existe pas ou est introuvable !');
                return $this->redirect($response, 'index');
            }
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable !');
            return $this->redirect($response, 'index');
        }
    }

    public function view(RequestInterface $request, ResponseInterface $response, $args)
    {
        $list = Liste::where('id', '=', $args['id'])->first();

        if (!is_null($list)) {
            $products = Product::join('list_products', 'list_products.id_prod', '=', 'product.id')
                ->join('list', 'list.id', '=', 'list_products.id_list')
                ->where('list.id', '=', $list->id)
                ->select(
                    'product.*',
                    'list_products.id as idListProducts',
                    'list_products.reserve as isReserved',
                    'list_products.user_reserve as userReserve'
                )
                ->get();


            $currentDate = strtotime(date('Y-m-d'));
            $exp_date = strtotime(date('Y-m-d', strtotime($list->date_exp)));

            $this->render($response, 'list/view', [
                'list' => $list,
                'products' => $products,
                'cookie' => isset($_COOKIE['mecado_' . $list->id]) ? true : false,
                'isEnded' => ($currentDate > $exp_date) ? true : false
            ]);
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable !');
            return $this->redirect($response, 'index');
        }
    }

    public function share(RequestInterface $request, ResponseInterface $response, $args)
    {
        $list = Liste::where('id', '=', $args['id'])->first();
        if (!is_null($list)) {
            $token = uniqid();
            $url = Picker::get('app.host');
            $url .= $this->container->get('router')
                ->pathFor('list.view.shared', [
                    'token' => $token
                ]);

            $list->url_share = $token;
            $list->save();

            $this->flash('success', 'URL de partage : ' . $url);
            return $this->redirect($response, 'list.view', [
                'id' => $list->id
            ]);
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable !');
            return $this->redirect($response, 'index');
        }
    }

    public function viewShared(RequestInterface $request, ResponseInterface $response, $args)
    {
        $list = Liste::where('url_share', '=', $args['token'])->first();
        if (!is_null($list)) {
            $products = Product::join('list_products', 'list_products.id_prod', '=', 'product.id')
                ->join('list', 'list.id', '=', 'list_products.id_list')
                ->where('list.id', '=', $list->id)
                ->select(
                    'product.*',
                    'list_products.id as idListProducts',
                    'list_products.reserve as isReserved',
                    'list_products.user_reserve as userReserve'
                )
                ->get();

            $currentDate = strtotime(date('Y-m-d'));
            $exp_date = strtotime(date('Y-m-d', strtotime($list->date_exp)));

            $this->render($response, 'list/view', [
                'list' => $list,
                'products' => $products,
                'sharedPage' => true,
                'cookie' => isset($_COOKIE['mecado_' . $list->id]) ? true : false,
                'canReserved' => ($currentDate > $exp_date) ? false : true
            ]);
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable.');
            return $this->redirect($response, 'index');
        }
    }

    public function remove(RequestInterface $request, ResponseInterface $response, $args)
    {
        $list = Liste::where('id', '=', $args['id'])->first();
        if (!is_null($list)) {
            $list->getComments()->delete();
            $listProducts = ListProducts::where('id_list', '=', $list->id)->get();
            foreach ($listProducts as $listProduct) {
                $listProduct->delete();
            }
            $list->getProducts()->delete();
            $list->delete();

            $this->flash('success', 'Liste supprimée avec succès.');
            return $this->redirect($response, 'user.view');
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable !');
            return $this->redirect($response, 'user.view');
        }
    }

    public function messages(RequestInterface $request, ResponseInterface $response, $args)
    {
        $list = Liste::where('id', '=', $args['id'])
            ->first();

        if (!is_null($list)) {
            $messages = $list->getComments()
                ->get();

            if (!empty($messages)) {
                $per_page = 5;
                $total = sizeof($messages);
                $offset = ($per_page * (!is_null($request->getParam('page')) ? ($request->getParam('page') - 1) : 0));

                $messages = $list->getComments()
                    ->limit($per_page)
                    ->offset($offset)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $this->render($response, 'list/messages', [
                    'list' => $list,
                    'messages' => $messages,
                    'pagination' => Paginator::paginate($per_page, $total, $request->getParam('page')),
                    'cookie' => isset($_COOKIE['mecado_' . $list->id]) ? true : false
                ]);
            } else {
                $this->flash('error', 'Les messages demandés n\'existent pas ou sont introuvables !');
                return $this->redirect($response, 'index');
            }
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable !');
            return $this->redirect($response, 'index');
        }
    }

    public function addmessage(RequestInterface $request, ResponseInterface $response, $args)
    {
        if (false === $request->getAttribute('csrf_status')) {
            $this->flash('error', 'Une erreur est survenue pendant l\'envoi du formulaire !');
            return $this->redirect($response, 'list.messages', $request->getparams());
        } else {
            $antiXssPseudo = new AntiXSS();
            $antiXssPseudo->xss_clean($request->getParam('pseudo'));

            $antiXssMessage = new AntiXSS();
            $antiXssMessage->xss_clean($request->getParam('message'));

            if (!$antiXssPseudo->isXssFound() && !$antiXssMessage->isXssFound()) {
                $errors = [];

                if (!Validator::stringType()->notEmpty()->validate($request->getParam('pseudo'))) {
                    $errors['pseudo'] = "Veuillez saisir un nom valide.";
                }

                if (!Validator::stringType()->notEmpty()->validate($request->getParam('message'))) {
                    $errors['message'] = "Veuillez saisir un message valide.";
                }

                if(!empty($request->getParam('pic'))){
                    if (!Validator::image()->validate($request->getParam('pic'))) {
                        $errors['pic'] = "Veuillez ajouter un fichier valide.";
                    }
                }

                $list = Liste::where('id', '=', $args['id'])
                    ->first();

                if (empty($errors)) {
                    if (!is_null($list)) {
                        $comment = new Comment();
                        $comment->id_list = $list->id;
                        $comment->author = $request->getParam('pseudo');
                        $comment->msg = $request->getParam('message');
                        $comment->save();

                        $this->flash('success', 'Votre message a bien été ajouté à la liste !');
                        return $this->redirect($response, 'list.messages', ['id' => $list->id]);
                    }
                    else {
                        $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable !');
                        return $this->redirect($response, 'index');
                    }

                } else {
                    $this->flash('errors', $errors);
                    return $this->redirect($response, 'list.messages', [
                        'id' => $list->id
                    ]);
                }
            } else {
                $this->flash('error', 'Impossible de traiter le formulaire !');
                return $this->redirect($response, 'list.messages', [
                    'id' => $list->id
                ]);
            }
        }
    }

    public function reserver(RequestInterface $request, ResponseInterface $response, $args)
    {
        if (false === $request->getAttribute('csrf_status')) {
            $this->flash('error', 'Une erreur est survenue pendant l\'envoi du formulaire !');
            return $this->redirect($response, 'index', $request->getparams());
        } else {
            $list = Liste::where('id', '=', $args['list'])->first();

            if (!is_null($list)) {
                $antiXssName = new AntiXSS();
                $antiXssName->xss_clean($request->getParam('name'));

                $antiXssMessage = new AntiXSS();
                $antiXssMessage->xss_clean($request->getParam('message'));

                if (!$antiXssName->isXssFound() && ! $antiXssMessage->isXssFound()) {
                    $errors = [];

                    if (!Validator::stringType()->notEmpty()->validate($request->getParam('name'))) {
                        $errors['name'] = "Veuillez saisir un nom valide.";
                    }

                    if (!Validator::stringType()->notEmpty()->validate($request->getParam('message'))) {
                        $errors['message'] = "Veuillez saisir un message valide.";
                    }

                    if (empty($errors)) {
                        $lisProducts = ListProducts::where('id', '=', $args['idListProducts'])->first();
                        if (!is_null($lisProducts)) {
                            $lisProducts->reserve = 1;
                            $lisProducts->user_reserve = $request->getParam('name');
                            $lisProducts->save();

                            Message::create([
                                'id_list_products' => $args['idListProducts'],
                                'author' => $request->getParam('name'),
                                'msg' => $request->getParam('message')
                            ]);

                            $this->flash('success', 'Produit réservé.');
                            return $this->redirect($response, 'list.view.shared', [
                                'token' => $list->url_share
                            ]);
                        } else {
                            $this->flash('error', 'Impossible de réserver le produit.');
                            return $this->redirect($response, 'list.view.shared', [
                                'token' => $list->url_share,
                            ]);
                        }
                    } else {
                        $errors['modal'] = $args['idListProdutcs'];

                        $this->flash('errors', $errors);
                        return $this->redirect($response, 'list.view.shared', [
                            'token' => $list->url_share,
                        ]);
                    }
                } else {
                    $this->flash('error', 'Impossible de traiter le formulaire !');
                    return $this->redirect($response, 'list.view.shared', [
                        'token' => $list->url_share,
                    ]);
                }
            } else {
                $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable !');
                return $this->redirect($response, 'index');
            }
        }
    }

    public function listEditForm(RequestInterface $request, ResponseInterface $response, $args)
    {
        $list = Liste::where('id', '=', $args['id'])->first();

        if (!is_null($list)) {
            $this->render($response, 'list/edit', [
                'list' => $list
            ]);
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable !');
            return $this->redirect($response, 'index');
        }
    }

    public function listEdit(RequestInterface $request, ResponseInterface $response, $args)
    {
        $list = Liste::where('id', '=', $args['id'])->first();
        if (!is_null($list)) {
            if (false === $request->getAttribute('csrf_status')) {
                $this->flash('error', 'Une erreur est survenue pendant l\'envoi du formulaire !');
                return $this->redirect($response, 'list.creationlist.form', $request->getparams());
            } else {
                $antiXssTitle = new AntiXSS();
                $antiXssTitle->xss_clean($request->getParam('list_title'));

                $antiXssDescr = new AntiXSS();
                $antiXssDescr->xss_clean($request->getParam('description'));

                $antiXssEndDate = new AntiXSS();
                $antiXssEndDate->xss_clean($request->getParam('end_date'));

                if (!$antiXssTitle->isXssFound() && !$antiXssDescr->isXssFound() && !$antiXssEndDate->isXssFound()) {
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
                    $date = strtotime(date('d/m/Y'));

                    if ($date > $dateListe) {
                        $errors['end_date'] = "Veuillez saisir une date qui n'est pas encore passée.";
                    }

                    if (empty($errors)) {
                        $list->name = $request->getParam('list_title');
                        $list->descr = $request->getParam('description');
                        $list->date_exp = date('Y-m-d H:i:s', strtotime($request->getParam('end_date')));
                        $list->other_dest = is_null($request->getParam('other_dest')) ? 0 : 1;

                        $list->id_creator = Session::get('user')->id;
                        $list->save();

                        if ($list->other_dest == 0) {
                            setcookie('mecado_' . $list->id, $list->id, strtotime($request->getParam('end_date')), '/', current($request->getHeader('Host')), false, true);
                        }

                        $this->flash('success', 'Liste mise à jour');
                        return $this->redirect($response, 'list.edit.form', [
                            'id' => $list->id
                        ]);

                    } else {
                        $this->flash('errors', $errors);
                        return $this->redirect($response, 'list.edit.form', [
                            'id' => $list->id
                        ]);
                    }
                } else {
                    $this->flash('error', 'Impossible de traiter le formulaire !');
                    return $this->redirect($response, 'list.edit.form', [
                        'id' => $list->id
                    ]);
                }
            }
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable !');
            return $this->redirect($response, 'index');
        }
    }

    public function removeProduct(RequestInterface $request, ResponseInterface $response, $args)
    {
        $list = Liste::where('id', '=', $args['list'])->first();
        if (!is_null($list)) {

            $listProduct = ListProducts::where('id_list', '=', $list->id)
                ->where('id_prod', '=', $args['prod'])
                ->first();

            if (!is_null($listProduct)) {
                $listProduct->delete();
                $this->flash('success', 'Prouit supprimé de la liste');
            } else {
                $this->flash('error', 'Impossible de supprimer le produit de la liste');
            }

            return $this->redirect($response, 'list.edit.form', [
                'id' => $list->id
            ]);
        } else {
            $this->flash('error', 'La liste demandée n\'existe pas ou est introuvable !');
            return $this->redirect($response, 'index');
        }
    }
}
