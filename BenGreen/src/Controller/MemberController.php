<?php

namespace App\Controller;

use App\Form\EditAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @Route("/userinfo/pass/edit", name="member_userpass_edit")
     */
    public function editUserPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if($request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            //to check if both passwords are identical :
            if($request->get('pass') == $request->get('pass2')){

                $user->setPassword($passwordEncoder->encodePassword($user, $request->get('pass')));
                $entityManager->flush();

                $this->addFlash('message', 'Mot de passe mis à jour avec succès!');

                return $this->redirectToRoute('member_userinfo');

            } else {
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques, vérifiez votre saisie.');
            }

        }

        return $this->render('member/editpassword.html.twig', [
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

    /**
     * @Route("/orderdetails", name="member_orderdetails")
     */
    public function showOrderdetails()
    {
        return $this->render('member/orderdetails.html.twig', ['mainNavMember'=>true, 'title'=>'Espace Membre']);
    }

    /**
     * @Route("/invoices", name="member_invoices")
     */
    public function showInvoices()
    {
        return $this->render('member/invoices.html.twig', ['mainNavMember'=>true, 'title'=>'Espace Membre']);
    }

}