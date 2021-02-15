<?php

namespace App\Service\Cart;

use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    protected $session;
    protected $productsRepository;

    public function __construct(SessionInterface $session, ProductsRepository $productsRepository) {
        $this->session = $session;
        $this->productsRepository = $productsRepository;
    }

    public function add(int $id) {
        //if no cart yet, I want an empty array as default value:
        $panier = $this->session->get('panier', []);

        //if cart not empty for this product, I want to add to the quantity of this product already in the cart :
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else {
            //I add 1 product with this id in the cart :
            $panier[$id] = 1;
        }

        //I save this new cart for this session :
        $this->session->set('panier', $panier);
        //test : dd($session->get('panier')); //test ok 07/12/20

    }

    public function remove(int $id) {
        $panier = $this->session->get('panier', []);

        //if this product id exists in cart, then I apply method unset to it :
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        //then I put back in the session the new modified cart :
        $this->session->set('panier', $panier);
    }

    public function getFullCart() : array {
        //I find the cart (or if empty, an empty array by default) :
        $panier = $this->session->get('panier', []);

        //I create an empty array to be filled with the data from cart with a loop:
        $panierWithData = [];
        foreach($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $this->productsRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $panierWithData;
    }

    public function getTotal() : float {
        //I create the cart total so that I can display it in the twig :
        $total = 0;

        foreach($this->getFullCart() as $item) {
            $total += $item['product']->getProductsPrice() * $item['quantity'];
        }

        return $total;
    }

}