<?php

namespace App\Controller;

use App\Entity\Enterprise;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\EnterpriseRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product/controller2")
 */
class ProductController2 extends AbstractController
{
    /**
     * @Route("/", name="product_controller2_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT e.country
            FROM App\Entity\Enterprise e'
        );

        return $this->render('product_controller2/index.html.twig', [

            'products' => $productRepository->findAll(),
            'countries' => $query->getResult()
        ]);
    }


    /**
     * @Route("/new", name="product_controller2_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_controller2_index');
        }

        return $this->render('product_controller2/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_controller2_show_admin", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product_controller2/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/pp/{id}", name="product_controller2_show_main", methods={"GET"})
     */
    public function showMain(Product $product): Response
    {
        return $this->render('product_controller2/mainShow.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_controller2_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_controller2_index');
        }

        return $this->render('product_controller2/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_controller2_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_controller2_index');
    }





}
