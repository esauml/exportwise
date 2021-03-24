<?php

namespace App\Controller;

use App\Entity\Shipment;
use App\Form\ShipmentType;
use App\Repository\ShipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shipment")
 */
class ShipmentController extends AbstractController
{
    /**
     * @Route("/", name="shipment_index", methods={"GET"})
     */
    public function index(ShipmentRepository $shipmentRepository): Response
    {
        return $this->render('shipment/index.html.twig', [
            'shipments' => $shipmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="shipment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $shipment = new Shipment();
        $form = $this->createForm(ShipmentType::class, $shipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shipment);
            $entityManager->flush();

            return $this->redirectToRoute('shipment_index');
        }

        return $this->render('shipment/new.html.twig', [
            'shipment' => $shipment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shipment_show", methods={"GET"})
     */
    public function show(Shipment $shipment): Response
    {
        return $this->render('shipment/show.html.twig', [
            'shipment' => $shipment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shipment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Shipment $shipment): Response
    {
        $form = $this->createForm(ShipmentType::class, $shipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shipment_index');
        }

        return $this->render('shipment/edit.html.twig', [
            'shipment' => $shipment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shipment_delete", methods={"POST"})
     */
    public function delete(Request $request, Shipment $shipment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shipment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shipment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shipment_index');
    }
}
