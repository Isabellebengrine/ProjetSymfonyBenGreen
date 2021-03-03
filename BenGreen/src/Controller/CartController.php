<?php

namespace App\Controller;

use App\Entity\Orderdetail;
use App\Entity\Totalorder;
use App\Form\CartType;
use App\Form\TotalorderType;
use App\Manager\CartManager;
use App\Repository\OrderdetailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="cart_index", methods={"GET", "POST"})
     */
    public function index(CartManager $cartManager, Request $request): Response
    {
        $cart = $cartManager->getCurrentCart();
        $form= $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        //if buttons are clicked on this form (carttype and cartitemtype that is nested inside carttype),
        //('clear', 'save' or 'remove' buttons), then the event listeners we created are triggered and
        //the event listeners postsubmit() methods are invoked (that is how the orderdetails are modified or deleted from the cart:
        //if there is no more orderdetails, the cart is empty but if something is now added to cart, it will get the new item(s):
        if ($form->isSubmitted() && $form->isValid()) {
            $cart->setUpdatedAt(new \DateTime());
            $cartManager->save($cart);

            return $this->redirectToRoute('cart_index');
        }
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $cart,
            'form' => $form->createView()
        ]);
    }

}
