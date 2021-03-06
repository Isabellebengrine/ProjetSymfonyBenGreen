<?php

namespace App\Controller;

use App\Entity\Orderdetail;
use App\Entity\Totalorder;
use App\Form\CartType;
use App\Form\CartValidationType;
use App\Form\TotalorderType;
use App\Manager\CartManager;
use App\Repository\OrderdetailRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
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
            $items = $cart->getOrderdetails();
            foreach($items as $item){
                $price = $item->setOrderdetailPrice($item->getProducts()->getProductsPrice());
            }
            $cartManager->save($cart);

            return $this->redirectToRoute('cart_index');
        }
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $cart,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/validation", name="cart_validation", methods={"GET", "POST"})
     */
    public function validateCart(CartManager $cartManager, Request $request, MailerInterface $mailer): Response
    {
        $cart = $cartManager->getCurrentCart();
        $cart->setUpdatedAt(new \DateTime());
        $items = $cart->getOrderdetails();
        foreach($items as $item){
            $price = $item->setOrderdetailPrice($item->getProducts()->getProductsPrice());
        }
        $cartManager->save($cart);
        $form = $this->createForm(CartValidationType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart->setStatus('commande');
            $this->getDoctrine()->getManager()->flush();

            // send an email to confirm the registration :
            $mail = $this->getUser()->getEmail();

            $email = (new TemplatedEmail())
                ->from('contact@bengreen.org')
                ->to($mail)
                ->subject('Confirmation de commande')
                ->htmlTemplate('emails/conf_commande.html.twig')
                ->context([
                    'username' => $this->getUser()->getFirstname(),
                    'commande' => $cart,
                    'articles' => $cart->getOrderdetails()
                ])
            ;
            $mailer->send($email);

            //affiche msg de confirmation :
            $this->addFlash(
                'success',
                'Votre commande a bien été enregistrée. Vous allez recevoir un e-mail de confirmation. Nous vous remercions de votre confiance!'
            );

            return $this->redirectToRoute('cart_index');
        }

        return $this->render('cart/validation.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $cart,
            'form' => $form->createView()
        ]);
    }

}
