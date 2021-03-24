<?php

namespace App\Controller;

use App\Entity\AcceptanceOrder;
use App\Form\AcceptanceOrderType;
use App\Repository\AcceptanceOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/acceptance/order")
 */
class AcceptanceOrderController extends AbstractController
{
    /**
     * @Route("/", name="acceptance_order_index", methods={"GET"})
     */
    public function index(AcceptanceOrderRepository $acceptanceOrderRepository): Response
    {
        return $this->render('acceptance_order/index.html.twig', [
            'acceptance_orders' => $acceptanceOrderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="acceptance_order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $acceptanceOrder = new AcceptanceOrder();
        $form = $this->createForm(AcceptanceOrderType::class, $acceptanceOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($acceptanceOrder);
            $entityManager->flush();

            return $this->redirectToRoute('acceptance_order_index');
        }

        return $this->render('acceptance_order/new.html.twig', [
            'acceptance_order' => $acceptanceOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="acceptance_order_show", methods={"GET"})
     */
    public function show(AcceptanceOrder $acceptanceOrder): Response
    {
        return $this->render('acceptance_order/show.html.twig', [
            'acceptance_order' => $acceptanceOrder,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="acceptance_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AcceptanceOrder $acceptanceOrder): Response
    {
        $form = $this->createForm(AcceptanceOrderType::class, $acceptanceOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('acceptance_order_index');
        }

        return $this->render('acceptance_order/edit.html.twig', [
            'acceptance_order' => $acceptanceOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="acceptance_order_delete", methods={"POST"})
     */
    public function delete(Request $request, AcceptanceOrder $acceptanceOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$acceptanceOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($acceptanceOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('acceptance_order_index');
    }
}
