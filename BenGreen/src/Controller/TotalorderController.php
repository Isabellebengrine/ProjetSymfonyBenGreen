<?php

namespace App\Controller;

use App\Entity\Totalorder;
use App\Form\TotalorderType;
use App\Repository\TotalorderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/totalorder")
 */
class TotalorderController extends AbstractController
{
    /**
     * @Route("/", name="totalorder_index", methods={"GET"})
     */
    public function index(TotalorderRepository $totalorderRepository): Response
    {
        return $this->render('totalorder/index.html.twig', [
            'totalorders' => $totalorderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="totalorder_new", methods={"GET","POST"})
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

            return $this->redirectToRoute('totalorder_index');
        }

        return $this->render('totalorder/new.html.twig', [
            'totalorder' => $totalorder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="totalorder_show", methods={"GET"})
     */
    public function show(Totalorder $totalorder): Response
    {
        return $this->render('totalorder/show.html.twig', [
            'totalorder' => $totalorder,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="totalorder_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Totalorder $totalorder): Response
    {
        $form = $this->createForm(TotalorderType::class, $totalorder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('totalorder_index');
        }

        return $this->render('totalorder/edit.html.twig', [
            'totalorder' => $totalorder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="totalorder_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Totalorder $totalorder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$totalorder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($totalorder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('totalorder_index');
    }
}
