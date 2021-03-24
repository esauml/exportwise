<?php

namespace App\Controller;

use App\Entity\DetailAcceptanceOrder;
use App\Form\DetailAcceptanceOrderType;
use App\Repository\DetailAcceptanceOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/detail/acceptance/order")
 */
class DetailAcceptanceOrderController extends AbstractController
{
    /**
     * @Route("/", name="detail_acceptance_order_index", methods={"GET"})
     */
    public function index(DetailAcceptanceOrderRepository $detailAcceptanceOrderRepository): Response
    {
        return $this->render('detail_acceptance_order/index.html.twig', [
            'detail_acceptance_orders' => $detailAcceptanceOrderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="detail_acceptance_order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $detailAcceptanceOrder = new DetailAcceptanceOrder();
        $form = $this->createForm(DetailAcceptanceOrderType::class, $detailAcceptanceOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detailAcceptanceOrder);
            $entityManager->flush();

            return $this->redirectToRoute('detail_acceptance_order_index');
        }

        return $this->render('detail_acceptance_order/new.html.twig', [
            'detail_acceptance_order' => $detailAcceptanceOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_acceptance_order_show", methods={"GET"})
     */
    public function show(DetailAcceptanceOrder $detailAcceptanceOrder): Response
    {
        return $this->render('detail_acceptance_order/show.html.twig', [
            'detail_acceptance_order' => $detailAcceptanceOrder,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="detail_acceptance_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DetailAcceptanceOrder $detailAcceptanceOrder): Response
    {
        $form = $this->createForm(DetailAcceptanceOrderType::class, $detailAcceptanceOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('detail_acceptance_order_index');
        }

        return $this->render('detail_acceptance_order/edit.html.twig', [
            'detail_acceptance_order' => $detailAcceptanceOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_acceptance_order_delete", methods={"POST"})
     */
    public function delete(Request $request, DetailAcceptanceOrder $detailAcceptanceOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailAcceptanceOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailAcceptanceOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('detail_acceptance_order_index');
    }
}
