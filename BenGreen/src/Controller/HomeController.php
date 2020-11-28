<?php

namespace App\Controller;

use App\Entity\Rubrique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 * @method render(string $string, array $array)
 */
class HomeController extends AbstractController {
    /**
     * @Route("/", name="home")
     */
    public function index() :Response
    {
        $repo = $this->getDoctrine()->getRepository(Rubrique::class);

        $rubriques = $repo->findIdLessThan(9);

        // affichage de la page d'accueil: cards avec rubriques principales:
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'rubriques' => $rubriques
        ]);
    }
}
