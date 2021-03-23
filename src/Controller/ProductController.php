<?php

namespace App\Controller;

use App\Entity\Enterprise;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use PhpParser\Node\Expr\Cast\Array_;
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
     * @Route("/api/products/get-all", name="products_get_all",
     * methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository(Product::class)->findAll();

        //setting resonse messages
        $jsonResponse = [];
        if (!empty($data)) {
            $jsonResponse['status'] = 'ok';
            # $jsonResponse['data'] = $data;
            foreach ($data as $dat) {
                $jsonResponse['data'] = [
                    'name' => $dat->getName(),
                    'description' => $dat->getDescription(),
                    'price' => $dat->getPrice(),
                    'image' => $dat->getImage(),
                    'status' => $dat->getStatus(),
                ];
            }
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
        $data = $this->repository->findOneBy(['id' => $id]);

        $jsonResponse = [];
        if (!empty($data)) {
            $jsonResponse['status'] = 'ok';
            $jsonResponse['data'] = $data;
        } else {
            $jsonResponse['status'] = 'error: no data found';
            $JsonResponse['data'] = $data;
        }

        return new JsonResponse($jsonResponse, Response::HTTP_OK);
    }

    /**
     * @Route("/api/products/post", name="products_add", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
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

        $auxSeller = new Enterprise();
        $auxSeller->setId($seller['id']);
        #$auxSeller->setCompanyName($data->seller->id);

        $product->setSeller((new Enterprise())->setId($seller['id'])); // cast to <Enterprise>
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setImage($image);
        $product->setStatus($status);

        $this->repository->create($product);

        return new JsonResponse(
            ['status' => 'Customer created!'],
            Response::HTTP_CREATED
        );
    }
}
