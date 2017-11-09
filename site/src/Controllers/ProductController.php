<?php
/**
 * Created by PhpStorm.
 * User: geoffrey
 * Date: 08/11/17
 * Time: 23:05
 */

namespace Mecado\Controllers;


use Mecado\Models\Product;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ProductController extends BaseController
{
    public function products(RequestInterface $request, ResponseInterface $response, $args) {
        $products = Product::where('custom_product','=','0')->get();

        if (!is_null($products)) {
            $this->render($response, 'product/products', ['products' => $products]);
        } else {
            $this->flash('error', 'Les produits n\'existent pas !');
            return $this->redirect($response, 'index');
        }
    }
}
