<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Products;
use App\Entity\Rubrique;
use App\Form\AddToCartType;
use App\Form\SearchForm;
use App\Manager\CartManager;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function index(ProductsRepository $repository, Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        [$min, $max] = $repository->findMinMax($data);
        $products = $repository->findSearch($data);
        //if the request is an ajax request (used to search in products list):
        if ($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('products/_products.html.twig', ['products' => $products]),
                'sorting' => $this->renderView('products/_sorting.html.twig', ['products' => $products]),
                'pagination' => $this->renderView('products/_pagination.html.twig', ['products' => $products])
            ]);
        }
        return $this->render('products/index.html.twig', [
            'products' => $products,
            //now that $form is created, send it to view :
            'form' => $form->createView(),
            'min' => $min,
            'max' => $max
        ]);
    }

    /**
     * @Route("/rubrique/{id}", name="productsbyrubrique_show", methods={"GET"}, requirements={"id"="\d+"})
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
     * @Route("/{id}", name="products_show", methods={"GET", "POST"}, requirements={"id"="\d+"}))
     * @return Response
     */
    public function show(Products $product, Request $request, CartManager $cartManager): Response
    {
        //adding the 'add to cart' option :
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $item->setProducts($product);
            $cart = $cartManager->getCurrentCart();
            $cart
                ->addOrderdetail($item)
                ->setUpdatedAt(new \DateTime());

            $cartManager->save($cart);

            //affiche msg de confirmation :
            $this->addFlash(
                'success',
                'Article ajouté au panier !!'
            );

            return $this->redirectToRoute('products_index');
        }

        return $this->render('products/show.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}
