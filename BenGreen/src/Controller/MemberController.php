<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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