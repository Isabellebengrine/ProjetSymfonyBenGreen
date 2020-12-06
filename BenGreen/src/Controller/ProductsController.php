<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Rubrique;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products")
 */
class ProductsController extends AbstractController
{
    /**
     * @Route("/", name="products_index", methods={"GET"})
     * @param ProductsRepository $productsRepository
     * @return Response
     */
    public function index(ProductsRepository $productsRepository): Response
    {
        return $this->render('products/index.html.twig', [
            'products' => $productsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/rubrique/{id}", name="productsbyrubrique_show", methods={"GET"}, requirements={"id"="\d+"}))
     */
    public function findProductsWithSousRubrique(ProductsRepository $productsRepository, int $id): Response
    {
        $rubrique = $this->getDoctrine()->getRepository(Rubrique::class)->find($id);

        $rubriqueid = $rubrique->getId();
        $products = $productsRepository->findWithRubrique($rubriqueid);

        // affichage : cards avec products de la rubrique choisie:
        return $this->render('products/withrubrique.html.twig', [
            'controller_name' => 'ProductsController',
            'rubrique' => $rubrique,
            'products' => $products
        ]);
    }


    /**
     * @Route("/new", name="products_new", methods={"GET","POST"})
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
            //redirection vers page index :
            return $this->redirectToRoute('products_index');
        }

        //faire un rendu de notre vue avec notre template :
        return $this->render('products/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="products_show", methods={"GET"}, requirements={"id"="\d+"}))
     * @return Response
     */
    public function show(Products $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="products_edit", methods={"GET","POST"}, requirements={"id"="\d+"}))
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
            return $this->redirectToRoute('products_index');
        }

        return $this->render('products/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="products_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     * @return Response
     */
    public function delete(Request $request, Products $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('products_index');
    }
}
