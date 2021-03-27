<?php

namespace App\Controller;

use App\Entity\Enterprise;
use App\Entity\Product;
use App\Entity\ProductSearch;
use App\Form\ProductSearchType;
use App\Form\ProductType;
use App\Repository\EnterpriseRepository;
use App\Repository\ProductRepository;
use ContainerGGpvuaY\PaginatorInterface_82dac15;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/product/controller2")
 */
class ProductController2 extends AbstractController
{

    /**
     * @Route("/", name="product_controller2_index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator, Request $request, ProductRepository $productRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $search = new ProductSearch();
        $data = $entityManager->getRepository(Product::class)->findAll();

        $form = $this->createForm(ProductSearchType::class, $search);
        $form->handleRequest($request);

        $query = $entityManager->createQuery(
            'SELECT DISTINCT e.country
            FROM App\Entity\Enterprise e'
        );
        if (sizeof($data) > 0) {
            $product = sizeof($data) - 1;
            return $this->render('product_controller2/index.html.twig', [
                'controller_name' => 'HomeController',
                'slider' => [
                    'price' => $data[$product]->getPrice(),
                    'name' => $data[$product]->getName(),
                    'description' => $data[$product]->getDescription(),
                ],
                'products' => $productRepository->findBy(
                    array(),
                    array('price' => 'ASC')
                ),
                'countries' => $query->getResult(),
                'form' => $form->createView()
            ]);
        } else {
            return $this->render('product_controller2/index.html.twig', [
                'controller_name' => 'HomeController',
                'slider' => [
                    'price' => '',
                    'name' => '',
                    'description' => '',
                ],
                'products' => $productRepository->findBy(
                    array(),
                    array('price' => 'ASC')
                ),
                'countries' => $query->getResult(),
                'form' => $form->createView()
            ]);
        }
    }
  
    /**
     * @Route("/enterprise/products", name="product_controller2_indexx", methods={"GET"})
     */
    public function indexx(ProductRepository $productRepository): Response
    {
        return $this->render('product_controller2/indexx.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }


    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('layouts/header.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/new", name="product_controller2_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userId = $this->getUser();

        $product = new Product();
        $product->setSeller($userId);
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
            $this->getDoctrine()
                ->getManager()
                ->flush();

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
        if (
            $this->isCsrfTokenValid(
                'delete' . $product->getId(),
                $request->request->get('_token')
            )
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_controller2_index');
    }
}
