<?php

namespace App\Controller;

use App\Entity\Enterprise;
use App\Entity\Product;
use App\Entity\PurchaseOrder;
use App\Repository\ProductRepository;
use stdClass;
#use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Validator\Constraints\Json;

class ProductController extends AbstractController
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/shopping-cart", name="shopping_cart", methods={"GET"})
     */
    public function showShoppingCart(Request $request)
    {
        // get logged user
        $id = $this->getDoctrine()
            ->getManager()
            ->getRepository(Enterprise::class)
            ->find($this->getUser()->getId())
            ->getId();

        if (!$id) {
            return $this->redirectToRoute('app_login');
        }

        $po = $this->getDoctrine()
            ->getManager()
            ->getRepository(PurchaseOrder::class)
            ->findOneBy(['buyer' => $id], ['id' => 'DESC']);
        # code...
        return $this->render('product_controller2/shopping-cart.html.twig', [
            'po' => $po,
        ]);
    }

    /**
     * @Route("/checkout", name="checkout", methods={"POST", "GET"})
     */
    public function getCheckout(Request $request): Response
    {
        return $this->render('product_controller2/checkout.html.twig');
    }

    /**
     * @Route("/api/products/get-all", name="products_get_all",
     * methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Product::class)->findAll();

        //setting response messages
        $jsonResponse = [];
        $jsonData = [];
        if (!empty($data)) {
            $jsonResponse['status'] = 'ok';
            #$jsonResponse['data'] = $data;
            foreach ($data as $dat) {
                $jsonData[] = [
                    'id' => $dat->getId(),
                    'name' => $dat->getName(),
                    'description' => $dat->getDescription(),
                    'price' => $dat->getPrice(),
                    'image' => $dat->getImage(),
                    'status' => $dat->getStatus(),
                    'seller' => [
                        'id' => $dat->getSeller()->getId(),
                        'company_name' => $dat->getSeller()->getCompanyName(),
                        'logo' => $dat->getSeller()->getLogo(),
                        'country' => $dat->getSeller()->getCountry(),
                        'contact_name' => $dat->getSeller()->getContactName(),
                    ],
                ];
            }
            $jsonResponse['data'] = $jsonData;
        } else {
            $jsonResponse['status'] = 'error';
            $jsonResponse['data'] = $data;
        }

        return new JsonResponse($jsonResponse, Response::HTTP_OK);
    }

    /**
     * @Route("/api/products/{id}", name="products_get_one",
     * methods={"GET"})
     */
    public function getById($id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Product::class)->findOneBy(['id' => $id]);

        //setting response messages
        $jsonResponse = [];
        if (!empty($data)) {
            $jsonResponse['status'] = 'ok';
            #$jsonResponse['data'] = $data;

            $jsonData = new stdClass(); // default object
            $jsonData->id = $data->getId();
            $jsonData->name = $data->getName();
            $jsonData->description = $data->getDescription();
            $jsonData->price = $data->getPrice();
            $jsonData->image = $data->getImage();
            $jsonData->status = $data->getStatus();
            $jsonData->seller = new stdClass(); // default object
            $jsonData->seller->id = $data->getSeller()->getId();
            $jsonData->seller->company_name = $data
                ->getSeller()
                ->getCompanyName();
            $jsonData->seller->logo = $data->getSeller()->getLogo();
            $jsonData->seller->country = $data->getSeller()->getCountry();
            $jsonData->seller->contact_name = $data
                ->getSeller()
                ->getContactName();

            $jsonResponse['data'] = $jsonData;
        } else {
            $jsonResponse['status'] = 'error';
            $jsonResponse['data'] = $data;
        }

        return new JsonResponse($jsonResponse, Response::HTTP_OK);
    }
    /**
     * @Route("/api/products/enterprise/{id}", name="products_get_by_enterprise",
     * methods={"GET"})
     */
    public function getAllbyEnterprise($id): JsonResponse
    {
        $data = $this->repository->findBy(['seller' => $id]);

        //setting response messages
        $jsonResponse = [];
        $jsonData = [];
        if (!empty($data)) {
            $jsonResponse['status'] = 'ok';
            #$jsonResponse['data'] = $data;
            foreach ($data as $dat) {
                $jsonData[] = [
                    'id' => $dat->getId(),
                    'name' => $dat->getName(),
                    'description' => $dat->getDescription(),
                    'price' => $dat->getPrice(),
                    'image' => $dat->getImage(),
                    'status' => $dat->getStatus(),
                    'seller' => [
                        'id' => $dat->getSeller()->getId(),
                        'company_name' => $dat->getSeller()->getCompanyName(),
                        'logo' => $dat->getSeller()->getLogo(),
                        'country' => $dat->getSeller()->getCountry(),
                        'contact_name' => $dat->getSeller()->getContactName(),
                    ],
                ];
            }
            $jsonResponse['data'] = $jsonData;
        } else {
            $jsonResponse['status'] = 'error';
            $jsonResponse['data'] = $data;
        }

        return new JsonResponse($jsonResponse, Response::HTTP_OK);
    }
    /**
     * @Route("/api/products", name="products_add", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        /* JSON example
            {
                "seller" : {
                    "id": 5
                    "company_name": "esau",
                    "logo": "string",
                    "country": "string",
                    "phone": "string",
                    "email": "esau@esau.com",
                    "password": "1234567",
                    "status": 1
                },
                "name": "esau product 2",
                "description": "description",
                "price": 12.9,
                "image": "####"
            }

        */
        $data = json_decode($request->getContent(), true);

        $seller = $data['seller'];
        # $sellerId = $this->getUser()->getId();
        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $image = $data['image'];
        $status = 1;

        if (
            empty($seller) ||
            empty($name) ||
            empty($description) ||
            empty($price) ||
            empty($image)
        ) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        // creating and setting product from arguments en Request
        # set Seller by CASTING Enterprise
        $product = new Product();

        // set seller from db
        $sellerEM = $this->getDoctrine()->getManager();
        $auxSeller = $sellerEM
            ->getRepository(Enterprise::class)
            ->findOneBy(['id' => $seller['id']]);
        # check if null
        if ($auxSeller == null) {
            throw new NotFoundHttpException('Enterprise argument not found');
        }

        $product->setSeller($auxSeller);
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setImage($image);
        $product->setStatus($status);

        // DB function
        $this->repository->create($product);

        return new JsonResponse(
            ['status' => 'Customer created!'],
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/api/products", name="products_update", methods={"PUT"})
     */
    public function update(Request $request): JsonResponse
    {
        /* JSON example
            {
                "id": 1,
                "seller" : {
                    "id": 4
                },
                "name": "esau product 2",
                "description": "description",
                "price": 12.9,
                "image": "####",
                "status": 1
            }

        */
        $data = json_decode($request->getContent(), true);

        $id = $data['id'];
        $seller = $data['seller'];
        # $sellerId = $this->getUser()->getId();
        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $image = $data['image'];
        $status = $data['status'];

        if (
            empty($id) ||
            empty($seller['id']) ||
            empty($name) ||
            empty($description) ||
            empty($price) ||
            empty($image) ||
            empty($status)
        ) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        // searching for existing product
        $productEM = $this->getDoctrine()->getManager();
        $product = $productEM
            ->getRepository(Product::class)
            ->findOneBy(['id' => $id]);
        # check if null
        if ($product == null) {
            throw new NotFoundHttpException('Wrong id argument for Product');
        }

        // get seller from db <Product>
        $auxSeller = $this->getDoctrine()
            ->getRepository(Enterprise::class)
            ->findOneBy(['id' => $seller['id']]);
        # check if null
        if ($auxSeller == null) {
            throw new NotFoundHttpException('Wrong id argument for Enterprise');
        }

        $product->setSeller($auxSeller);
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setImage($image);
        $product->setStatus($status);

        // DB function
        $this->repository->update($product);

        return new JsonResponse(
            ['status' => 'Customer updated!'],
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/api/products/{id}", name="products_delete", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $data = $this->repository->findOneBy(['id' => $id]);

        // set return status based on <Product> existance
        $status = 'Operation Done: Delete successfull';
        if ($data == null) {
            throw new NotFoundHttpException(
                'Operation failure: no product existance'
            );
            $status = 'Operation failure: no product existance';
        }

        $this->repository->delete($data);

        // return JsonResponse
        return new JsonResponse(['status' => $status], Response::HTTP_OK);
    }

    /**
     * @Route("/products", name="product_index")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', []);
    }
}
