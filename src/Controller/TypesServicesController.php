<?php

namespace App\Controller;

use App\Entity\TypesServices;
use App\Form\TypesServicesType;
use App\Repository\TypesServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/types/services')]
class TypesServicesController extends AbstractController
{
    #[Route('/', name: 'app_types_services_index', methods: ['GET'])]
    public function index(TypesServicesRepository $typesServicesRepository): Response
    {
        return $this->render('types_services/index.html.twig', [
            'types_services' => $typesServicesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_types_services_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypesServicesRepository $typesServicesRepository): Response
    {
        $typesService = new TypesServices();
        $form = $this->createForm(TypesServicesType::class, $typesService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typesServicesRepository->save($typesService, true);

            return $this->redirectToRoute('app_types_services_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('types_services/new.html.twig', [
            'types_service' => $typesService,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_types_services_show', methods: ['GET'])]
    public function show(TypesServices $typesService): Response
    {
        return $this->render('types_services/show.html.twig', [
            'types_service' => $typesService,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_types_services_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypesServices $typesService, TypesServicesRepository $typesServicesRepository): Response
    {
        $form = $this->createForm(TypesServicesType::class, $typesService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typesServicesRepository->save($typesService, true);

            return $this->redirectToRoute('app_types_services_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('types_services/edit.html.twig', [
            'types_service' => $typesService,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_types_services_delete', methods: ['POST'])]
    public function delete(Request $request, TypesServices $typesService, TypesServicesRepository $typesServicesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typesService->getId(), $request->request->get('_token'))) {
            $typesServicesRepository->remove($typesService, true);
        }

        return $this->redirectToRoute('app_types_services_index', [], Response::HTTP_SEE_OTHER);
    }
}
