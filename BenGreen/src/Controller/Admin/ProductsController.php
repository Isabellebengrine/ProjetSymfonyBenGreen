<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/products", name="admin_products_")
 */
class ProductsController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(ProductsRepository $pRepository): Response
    {
        return $this->render('admin/products/index.html.twig', [
            'controller_name' => 'ProductsController',
            'products' => $pRepository->findAll(),
            'mainNavAdmin' => true,
            'title' => 'Espace Admin',
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $product = new Products();

        //création du form :
        $form = $this->createForm(ProductsType::class, $product);

        //lecture du form :
        $form->handleRequest($request);

        //si form soumis et valide, j'ajoute données dans bdd :
        if ($form->isSubmitted() && $form->isValid()) {
            /* pb avec upload du fichier sur le nom de $newPicture donc à finir :
                        // récupération de la saisie sur l'upload
                        $pictureFile = $form['picture2']->getData();
                        // vérification s'il y a un upload photo
                        if ($pictureFile) {
                            // renommage du fichier
                            // nom du fichier + extension
                            $newPicture = $id . '.' . $pictureFile->guessExtension();
                            // assignation de la valeur à la propriété picture à l'aide du setter
                            $product->setProductsPicture($newPicture);
                            try {
                                // déplacement du fichier vers le répertoire de destination sur le serveur
                                $pictureFile->move(
                                    $this->getParameter('photo_directory'),
                                    $newPicture
                                );
                            } catch (FileException $e) {
                                // gestion de l'erreur si le déplacement ne s'est pas effectué
                            }
                        }
            */

            $entityManager = $this->getDoctrine()->getManager();

            //pour préparer notre entité à la sauvegarde des données saisies :
            $entityManager->persist($product);
            //pour envoyer données dans bdd :
            $entityManager->flush();

            //affiche msg de confirmation :
            $this->addFlash(
                'success',
                'Produit ajouté avec succès !!'
            );
            //redirection vers page admin Produits :
            return $this->redirectToRoute('admin_products_home');
        }

        //faire un rendu de notre vue avec notre template :
        return $this->render('admin/products/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'mainNavAdmin' => true,
            'title' => 'Espace Admin',
        ]);
    }


    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     * @return Response
     */

    //ici on veut éditer un pdt spécifiq donc on injecte l'objet product à la méthode edit :
    public function edit(Request $request, Products $product): Response
    {
        // récupération de l'id du produit
        //nécessaire pour upload mais pb 181120 donc à revoir : $idProduct = $product->getId();
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /*
                        // récupération de la saisie sur l'upload
                        $pictureFile = $form['picture2']->getData();
                        // vérification s'il y a un upload photo
                        if ($pictureFile) {
                            // renommage du fichier
                            // nom du fichier + extension
                            $newPicture = $idProduct . '.' . $pictureFile->guessExtension();
                            // assignation de la valeur à la propriété picture à l'aide du setter
                            $product->setProductsPicture($newPicture);
                            try {
                                // déplacement du fichier vers le répertoire de destination sur le serveur
                                $pictureFile->move(
                                    $this->getParameter('photo_directory'),
                                    $newPicture
                                );
                            } catch (FileException $e) {
                                // gestion de l'erreur si le déplacement ne s'est pas effectué
                            }
                        }
            */
            $this->getDoctrine()->getManager()->flush();

            //affiche msg de confirmation :
            $this->addFlash(
                'success',
                'Produit modifié avec succès !!'
            );
            return $this->redirectToRoute('admin_products_home');
        }

        return $this->render('admin/products/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'mainNavAdmin' => true,
            'title' => 'Espace Admin',
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"}, requirements={"id"="\d+"})
     * @return Response
     */
    public function delete(Request $request, Products $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_products_home');
    }



}
