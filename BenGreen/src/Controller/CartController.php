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
    public function index(OrderdetailRepository $orderdetailRepository, CartManager $cartManager, Request $request): Response
    {
        $cart = $cartManager->getCurrentCart();
        $form= $this->createForm(TotalorderType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart->setUpdatedAt(new \DateTime());
            $cartManager->save($cart);

            return $this->redirectToRoute('cart_index');
        }
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'OrderdetailController',
            'cart' => $cart,
            'form' => $form->createView(),
            'orderdetails' => $orderdetailRepository->findByTotalorder($cart)
        ]);
    }

}
