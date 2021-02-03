<?php

namespace App\Controller;

use App\Form\EditAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/member") */
class MemberController extends AbstractController
{

    /**
    * @Route("/", name="member_home")
    */
    public function index()
    {
        return $this->render('member/index.html.twig', ['mainNavMember'=>true, 'title'=>'Espace Membre']);
    }

    /**
     * @Route("/userinfo/edit", name="member_userinfo_edit")
     */
    public function editUserinfo(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditAccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Compte mis à jour !');

            return $this->redirectToRoute('member_userinfo');
        }

        return $this->render('member/editaccount.html.twig', [
            'form' => $form->createView(),
            'mainNavMember'=>true,
            'title'=>'Espace Membre',
        ]);
    }


    /**
     * @Route("/userinfo", name="member_userinfo")
     */
    public function showUserInfo()
    {
        return $this->render('member/user.html.twig', ['mainNavMember'=>true, 'title'=>'Espace Membre']);
    }

    /**
     * @Route("/customer", name="member_customer")
     */
    public function showCustomerInfo()
    {
        return $this->render('member/customer.html.twig', ['mainNavMember'=>true, 'title'=>'Espace Membre']);
    }

    /**
     * @Route("/orders", name="member_orders")
     */
    public function showOrders()
    {
        return $this->render('member/orders.html.twig', ['mainNavMember'=>true, 'title'=>'Espace Membre']);
    }

}