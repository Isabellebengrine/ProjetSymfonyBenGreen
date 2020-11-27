<?php

namespace App\Controller;

use App\Entity\Suppliers;
use App\Repository\SuppliersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/suppliers")
 * @method render(string $string, array $array)
 */
class SuppliersController extends AbstractController
{
    /**
     * @Route("/", name="suppliers_index")
     */
    public function index(SuppliersRepository $suppliersRepository): Response
    {
        //j'interroge bdd pour chercher tous les suppliers
        $suppliers = $this->getDoctrine()->getRepository(Suppliers::class)->findAll();
        //je retourne le resultat
        return $this->render('suppliers/index.html.twig', [
            'controller_name' => 'SuppliersController',
            'suppliers' => $suppliers,
        ]);
    }
}
