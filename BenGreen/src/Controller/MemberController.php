<?php

namespace App\Controller;

use App\Entity\Categorietva;
use App\Entity\Customers;
use App\Entity\Employee;
use App\Entity\Totalorder;
use App\Entity\User;
use App\Form\CustomersType;
use App\Form\EditAccountType;
use App\Repository\OrderdetailRepository;
use App\Repository\TotalorderRepository;
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
     * @Route("/customer/{id}/edit", name="member_customer_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function editCustomerInfo(): Response
    {
        //to finish - 04/02/2021:
        return $this->render('member/customer_edit.html.twig', [
            'mainNavMember'=>true,
            'title'=>'Espace Membre']);
    }

    /**
     * @Route("/customer/new", name="member_customer_add", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function addCustomer(Request $request): Response
    {
        $customer = new Customers();
        $form = $this->createForm(CustomersType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            //to add customer-id number in user table for this user:
            $userRepo = $entityManager->getRepository(User::class);
            $user = $userRepo->find($this->getUser());
            $user->setCustomer($customer);

            //to add first and last names in user table from customer's name:
            $names = explode(' ', $customer->getCustomersName());
            $user->setLastname($names[1]);
            $user->setFirstname($names[0]);

            $entityManager->persist($customer);
            $entityManager->flush();

            //affiche msg de confirmation :
            $this->addFlash(
                'success',
                'Vos informations ont bien été enregistrées avec succès !!'
            );
            //redirection vers page Espace Membre/customer :
            return $this->redirectToRoute('member_customer');
        }

        return $this->render('member/customer_add.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
            'mainNavMember'=>true,
            'title'=>'Espace Membre']);
    }

    /**
     * @Route("/orders/{id}", name="member_orders", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showOrders(TotalorderRepository $totalorderRepository, int $id): Response
    {
        $customer = $this->getDoctrine()->getRepository(Customers::class)->find($id);
        $customerId = $customer->getId();
        $totalorders = $totalorderRepository->findByCustomer($customerId);
        return $this->render('member/orders.html.twig', [
            'controller_name' => 'MemberController',
            'customer' => $customer,
            'totalorders' => $totalorders,
            'mainNavMember'=>true,
            'title'=>'Espace Membre']);
    }

    /**
     * @Route("/orderdetails/totalorder/{id}", name="member_orderdetails", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function showOrderdetails(OrderdetailRepository $orderdetailRepository, int $id): Response
    {
        $totalorder = $this->getDoctrine()->getRepository(Totalorder::class)->find($id);
        $totalorderId = $totalorder->getId();
        $orderdetails = $orderdetailRepository->findByTotalorder($totalorderId);
        return $this->render('member/orderdetails.html.twig', [
            'controller_name' => 'MemberController',
            'orderdetails' => $orderdetails,
            'totalorder' => $totalorder,
            'mainNavMember'=>true,
            'title'=>'Espace Membre']);
    }

    /**
     * @Route("/invoices", name="member_invoices", methods={"GET"})
     */
    public function showInvoices()
    {
        return $this->render('member/invoices.html.twig', [
            'mainNavMember'=>true,
            'title'=>'Espace Membre']);
    }

}