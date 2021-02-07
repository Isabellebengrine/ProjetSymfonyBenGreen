<?php

namespace App\Controller\Admin;

use App\Entity\Suppliers;
use App\Form\SuppliersType;
use App\Repository\SuppliersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/suppliers", name="admin_suppliers_")
 */
class SuppliersController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(SuppliersRepository $suppliersRepository): Response
    {
        return $this->render('admin/suppliers/index.html.twig', [
            'controller_name' => 'SuppliersController',
            'suppliers' => $suppliersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $supplier = new Suppliers();
        $form = $this->createForm(SuppliersType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplier);
            $entityManager->flush();

            return $this->redirectToRoute('admin_suppliers_home');
        }

        return $this->render('admin/suppliers/new.html.twig', [
            'supplier' => $supplier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Suppliers $supplier): Response
    {
        return $this->render('admin/suppliers/show.html.twig', [
            'supplier' => $supplier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Suppliers $supplier): Response
    {
        $form = $this->createForm(SuppliersType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_suppliers_index');
        }

        return $this->render('admin/suppliers/edit.html.twig', [
            'supplier' => $supplier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Suppliers $supplier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supplier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($supplier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_suppliers_home');
    }
}
