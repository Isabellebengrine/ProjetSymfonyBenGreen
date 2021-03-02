<?php

namespace App\Controller\Admin;

use App\Entity\Totalorder;
use App\Form\TotalorderType;
use App\Repository\TotalorderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/totalorders", name="admin_totalorders_")
 */
class TotalorderController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(TotalorderRepository $totalorderRepository): Response
    {
        return $this->render('admin/totalorder/index.html.twig', [
            'totalorders' => $totalorderRepository->findAll(),
            'controller_name' => 'TotalorderController',
            'mainNavAdmin' => true,
            'title' => 'Espace Admin',
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $totalorder = new Totalorder();
        $form = $this->createForm(TotalorderType::class, $totalorder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($totalorder);
            $entityManager->flush();

            return $this->redirectToRoute('admin_totalorders_home');
        }

        return $this->render('admin/totalorder/new.html.twig', [
            'totalorder' => $totalorder,
            'controller_name' => 'TotalorderController',
            'form' => $form->createView(),
            'mainNavAdmin' => true,
            'title' => 'Espace Admin'
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Totalorder $totalorder): Response
    {
        return $this->render('admin/totalorder/show.html.twig', [
            'totalorder' => $totalorder,
            'controller_name' => 'TotalorderController',
            'mainNavAdmin' => true,
            'title' => 'Espace Admin'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Totalorder $totalorder): Response
    {
        $form = $this->createForm(TotalorderType::class, $totalorder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_totalorders_home');
        }

        return $this->render('admin/totalorder/edit.html.twig', [
            'controller_name' => 'TotalorderController',
            'totalorder' => $totalorder,
            'form' => $form->createView(),
            'mainNavAdmin' => true,
            'title' => 'Espace Admin'
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Totalorder $totalorder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$totalorder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($totalorder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_totalorders_home');
    }
}
