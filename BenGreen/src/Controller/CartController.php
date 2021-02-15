<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(SessionInterface $session, ProductsRepository $productsRepository): Response
    {
        //I find the cart (or if empty, an empty array by default) :
        $panier = $session->get('panier', []);

        //I create an empty array to be filled with the data from cart with a loop:
        $panierWithData = [];
        foreach($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $productsRepository->find($id),
                'quantity' => $quantity
            ];
        }

        //I create the total so that I can display it in the twig :
        $total = 0;
        foreach($panierWithData as $item) {
            $totalItem = $item['product']->getProductsPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'items' => $panierWithData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, SessionInterface $session) {

        //if no cart yet, I want an empty array as default value:
        $panier = $session->get('panier', []);

        //if cart not empty for this product, I want to add to the quantity of this product already in the cart : :
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else {
            //I add 1 product with this id in the cart :
            $panier[$id] = 1;
        }

        //I save this new cart for this session :
        $session->set('panier', $panier);
        //test : dd($session->get('panier')); //test ok 07/12/20

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, SessionInterface $session) {
        $panier = $session->get('panier', []);

        //if this product id exists in cart, then I apply method unset to it :
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        //then I put back in the session the new modified cart :
        $session->set('panier', $panier);

        //then I redirect to the cart index showing updated list of items in cart :
        return $this->redirectToRoute("cart_index");
    }

}
