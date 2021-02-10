<?php

namespace App\Controller\Admin;

use App\Entity\Purchases;
use App\Form\PurchasesType;
use App\Repository\PurchasesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/purchases", name="admin_purchases_")
 */
class PurchasesController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(PurchasesRepository $purchasesRepository): Response
    {
        return $this->render('admin/purchases/index.html.twig', [
            'controller_name' => 'PurchasesController',
            'purchases' => $purchasesRepository->findAll(),
            'mainNavAdmin' => true,
            'title' => 'Espace Admin',
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $purchase = new Purchases();
        $form = $this->createForm(PurchasesType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($purchase);
            $entityManager->flush();

            return $this->redirectToRoute('admin_purchases_home');
        }

        return $this->render('admin/purchases/new.html.twig', [
            'controller_name' => 'PurchasesController',
            'purchase' => $purchase,
            'form' => $form->createView(),
            'mainNavAdmin' => true,
            'title' => 'Espace Admin',
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Purchases $purchase): Response
    {
        return $this->render('admin/purchases/show.html.twig', [
            'purchase' => $purchase,
            'mainNavAdmin' => true,
            'title' => 'Espace Admin',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Purchases $purchase): Response
    {
        $form = $this->createForm(PurchasesType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_purchases_home');
        }

        return $this->render('admin/purchases/edit.html.twig', [
            'purchase' => $purchase,
            'form' => $form->createView(),
            'mainNavAdmin' => true,
            'title' => 'Espace Admin',
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Purchases $purchase): Response
    {
        if ($this->isCsrfTokenValid('delete'.$purchase->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($purchase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_purchases_home');
    }
}
