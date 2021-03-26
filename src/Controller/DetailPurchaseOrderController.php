<?php

namespace App\Controller;

use App\Entity\DetailPurchaseOrder;
use App\Entity\Product;
use App\Entity\Enterprise;
use App\Form\DetailPurchaseOrderType;
use App\Repository\DetailPurchaseOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/detail/purchase/order")
 */
class DetailPurchaseOrderController extends AbstractController
{
    /**
     * @Route("/", name="detail_purchase_order_index", methods={"GET"})
     */
    public function index(DetailPurchaseOrderRepository $detailPurchaseOrderRepository): Response
    {
        return $this->render('detail_purchase_order/index.html.twig', [
            'detail_purchase_orders' => $detailPurchaseOrderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="detail_purchase_order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $detailPurchaseOrder = new DetailPurchaseOrder();
        $form = $this->createForm(DetailPurchaseOrderType::class, $detailPurchaseOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detailPurchaseOrder);
            $entityManager->flush();

            return $this->redirectToRoute('detail_purchase_order_index');
        }

        return $this->render('detail_purchase_order/new.html.twig', [
            'detail_purchase_order' => $detailPurchaseOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="detail_purchase_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DetailPurchaseOrder $detailPurchaseOrder): Response
    {
        $form = $this->createForm(DetailPurchaseOrderType::class, $detailPurchaseOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('detail_purchase_order_index');
        }

        return $this->render('detail_purchase_order/edit.html.twig', [
            'detail_purchase_order' => $detailPurchaseOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_purchase_order_delete", methods={"POST", "GET"})
     */
    public function delete(Request $request, DetailPurchaseOrder $detailPurchaseOrder): Response
    {
        dump($detailPurchaseOrder);
        if ($this->getUser()) {
            dump("here");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailPurchaseOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shopping_cart');
    }
}
