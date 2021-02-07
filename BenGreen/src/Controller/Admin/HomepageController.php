<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index() {
        return $this->render('admin/homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'mainNavAdmin' => true,
            'title' => 'Espace Admin']);
    }
}