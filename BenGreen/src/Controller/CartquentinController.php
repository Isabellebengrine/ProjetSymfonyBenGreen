<?php

namespace App\Controller;

use App\Form\CartType;
use App\Manager\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartquentinController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(CartManager $cartManager): Response
    {
        $cart = $cartManager->getCurrentCart();
        $form= $this->createForm(CartType::class, $cart);

        return $this->render('cart/indexquentin.html.twig', [
            'controller_name' => 'CartquentinController',
            'cart' => $cart,
            'form' => $form->createView()
        ]);
    }
}
