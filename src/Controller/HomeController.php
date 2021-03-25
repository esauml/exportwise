<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Product::class)->findAll();
        $query = $em->createQuery(
            'SELECT DISTINCT e.country
            FROM App\Entity\Enterprise e'
        );
        if(sizeof($data)>0){
            $product = sizeof($data) - 1;
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'slider' => [
                    'price' => $data[$product]->getPrice(),
                    'name' => $data[$product]->getName(),
                    'description' => $data[$product]->getDescription(),
                ],
                'countries' => $query->getResult()
            ]);
        }
        else{
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'slider' => [
                    'price' => '',
                    'name' =>'',
                    'description' => '',
                ],
                'countries' => $query->getResult()
            ]);
        }
       
        
    }
}