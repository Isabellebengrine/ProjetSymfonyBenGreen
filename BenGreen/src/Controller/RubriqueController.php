<?php

namespace App\Controller;

use App\Entity\Rubrique;
use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rubrique")
 */
class RubriqueController extends AbstractController
{
    /**
     * @Route("/{id}", name="rubrique_show", methods={"GET"}, requirements={"id"="\d+"}))
     */
    public function findsousRubrique(RubriqueRepository $rubriqueRepository, int $id): Response
    {
        $rubrique = $this->getDoctrine()->getRepository(Rubrique::class)->find($id);

        $parent = $rubrique->getId();
        $sousrubriques = $rubriqueRepository->findWithParent($parent);

        // affichage : cards avec sous-rubriquesde la rubrique choisie:
        return $this->render('rubrique/index.html.twig', [
            'controller_name' => 'RubriqueController',
            'rubrique' => $rubrique,
            'sousrubriques' => $sousrubriques
        ]);

    }
}
