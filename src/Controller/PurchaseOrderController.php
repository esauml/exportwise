<?php

namespace App\Controller;

use App\Entity\PurchaseOrder;
use App\Form\PurchaseOrderType;
use App\Repository\PurchaseOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/purchase/order")
 */
class PurchaseOrderController extends AbstractController
{
    /**
     * @Route("/", name="purchase_order_index", methods={"GET"})
     */
    public function index(PurchaseOrderRepository $purchaseOrderRepository): Response
    {
        return $this->render('purchase_order/index.html.twig', [
            'purchase_orders' => $purchaseOrderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="purchase_order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $purchaseOrder = new PurchaseOrder();
        $form = $this->createForm(PurchaseOrderType::class, $purchaseOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($purchaseOrder);
            $entityManager->flush();

            return $this->redirectToRoute('purchase_order_index');
        }

        return $this->render('purchase_order/new.html.twig', [
            'purchase_order' => $purchaseOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="purchase_order_show", methods={"GET"})
     */
    public function show(PurchaseOrder $purchaseOrder): Response
    {
        return $this->render('purchase_order/show.html.twig', [
            'purchase_order' => $purchaseOrder,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="purchase_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PurchaseOrder $purchaseOrder): Response
    {
        $form = $this->createForm(PurchaseOrderType::class, $purchaseOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('purchase_order_index');
        }

        return $this->render('purchase_order/edit.html.twig', [
            'purchase_order' => $purchaseOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="purchase_order_delete", methods={"POST"})
     */
    public function delete(Request $request, PurchaseOrder $purchaseOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$purchaseOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($purchaseOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('purchase_order_index');
    }
}
