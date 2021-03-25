<?php

namespace App\Controller;

use DateTime;
use App\Entity\Product;
use App\Entity\Enterprise;
use App\Entity\PurchaseOrder;
use App\Form\PurchaseOrderType;
use App\Entity\DetailPurchaseOrder;
use ApiPlatform\Core\Filter\Validator\Enum;
use App\Repository\PurchaseOrderRepository;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("api/purchase-order")
 */
class PurchaseOrderController extends AbstractController
{
    /**
     * @Route("/", name="purchase_order_index", methods={"GET"})
     */
    public function index(
        PurchaseOrderRepository $purchaseOrderRepository
    ): Response {
        return $this->render('purchase_order/index.html.twig', [
            'purchase_orders' => $purchaseOrderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="purchase_order_new", methods={"GET","POST"})
     */
    public function new(Request $request): JsonResponse
    {
        $status = '';
        $data = json_decode($request->getContent(), true);

        if (empty($data['idSeller']) || empty($data['detailsPO'])) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $po = new PurchaseOrder();

        $status = 'created';
        // if already created
        if (!empty($data['id'])) {
            $po = $this->getDoctrine()
                ->getManager()
                ->getRepository(PurchaseOrder::class)
                ->find($data['id']);

            $status = 'updated';
        }

        $gdate = getdate();
        $gdate =
            $gdate['year'] .
            '-' .
            $gdate['mon'] .
            '-' .
            $gdate['mday'] .
            ' ' .
            $gdate['hours'] .
            ':' .
            $gdate['minutes'] .
            ':' .
            $gdate['seconds'];
        $date = new DateTime($gdate);
        $po->setDateDone($date);

        // $po->setBuyerId($this->getUser()->getId());
        $enterprise = $this->getDoctrine()
            ->getManager()
            ->getRepository(Enterprise::class)
            ->find(1);
        $po->setBuyerId($enterprise);

        // find seller in db
        $seller = $this->getDoctrine()
            ->getManager()
            ->getRepository(Enterprise::class)
            ->find($data['idSeller']);

        $po->setSellerId($seller);

        /*
            1: just created
            2: confirmed
            3: delete
        */
        $po->setStatus(1);

        foreach ($data['detailsPO'] as $detailPO) {
            $detail = new DetailPurchaseOrder();

            //search for detailPO in case of existance
            if (!empty($detailPO['id'])) {
                $detail = $this->getDoctrine()
                    ->getManager()
                    ->getRepository(DetailPurchaseOrder::class)
                    ->find($data['id']);
            }

            $detail->setQuantity($detailPO['quantity']);

            // find product from db
            $product = $this->getDoctrine()
                ->getManager()
                ->getRepository(Product::class)
                ->find($detailPO['productId']);
            $detail->setProductId($product);

            $po->addDetailPurchaseOrder($detail);
        }

        /*
            *   
            ¨*idSeller,2
            *status,
            detailsPO: [
                if exists: id
                quantity 3
                prductId 2
            ]
            {
                idSeller: 1,
                detailsPO:{
                    quantity: 3,
                    productId:2
                }
            }
        */

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($po);
        $entityManager->flush();

        $jsonReturn = [
            'status' => $status,
            'data' => json_decode($po->strval()),
        ];

        return new JsonResponse($jsonReturn, Response::HTTP_OK);
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
    public function edit(
        Request $request,
        PurchaseOrder $purchaseOrder
    ): Response {
        $form = $this->createForm(PurchaseOrderType::class, $purchaseOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

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
    public function delete(
        Request $request,
        PurchaseOrder $purchaseOrder
    ): Response {
        if (
            $this->isCsrfTokenValid(
                'delete' . $purchaseOrder->getId(),
                $request->request->get('_token')
            )
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($purchaseOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('purchase_order_index');
    }
}
