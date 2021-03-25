<?php

namespace App\Controller;

use App\Entity\Enterprise;
use App\Form\EnterpriseRegistrationType;
use App\Form\EnterpriseType;
use App\Repository\EnterpriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/enterprise")
 */
class EnterpriseController extends AbstractController
{
    private $repository;

    public function __construct(EnterpriseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="enterprise_index", methods={"GET"})
     */
    public function index(EnterpriseRepository $enterpriseRepository): Response
    {
        return $this->render('enterprise/index.html.twig', [
            'enterprises' => $enterpriseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/profile", name="enterprise_show", methods={"GET"})
     */
    public function profile(): Response
    {
        $userId = $this->getUser()->getId();

        $enterprise = $this->repository->findOneBy(['id' => $userId]);

        return $this->render('enterprise/profile.html.twig', [
            'enterprise' => $enterprise,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="enterprise_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Enterprise $enterprise): Response
    {
        $form = $this->createForm(EnterpriseType::class, $enterprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();

            return $this->redirectToRoute('enterprise_index');
        }

        return $this->render('enterprise/edit.html.twig', [
            'enterprise' => $enterprise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="enterprise_delete", methods={"POST"})
     */
    public function delete(Request $request, Enterprise $enterprise): Response
    {
        if (
            $this->isCsrfTokenValid(
                'delete' . $enterprise->getId(),
                $request->request->get('_token')
            )
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($enterprise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('enterprise_index');
    }
}
