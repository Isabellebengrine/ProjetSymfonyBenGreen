<?php

namespace App\Controller;

use App\Entity\Rubrique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    /**
     * @Route("/catalogue", name="catalogue")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Rubrique::class);
        $obj = $repo->findOneBy(['id' => 1]);

        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'obj' =>  $obj
        ]);
    }

    /**
     * @Route("/catalogue/12", name="catalogue_show")
     */
    public function show() {
        return $this->render('catalogue/show.html.twig', []);
    }
}
