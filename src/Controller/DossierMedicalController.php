<?php

namespace App\Controller;

use App\Entity\DossierMedical;
use App\Form\DossierMedicalType;
use App\Repository\DossierMedicalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/DossierMedical')]
class DossierMedicalController extends AbstractController
{
    #[Route('/', name: 'app_DossierMedical_index', methods: ['GET'])]
    public function index(DossierMedicalRepository $DossierMedicalRepository): Response
    {
        return $this->render('DossierMedical/index.html.twig', [
            'DossierMedicals' => $DossierMedicalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_DossierMedical_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DossierMedicalRepository $DossierMedicalRepository): Response
    {
        $DossierMedical = new DossierMedical();
        $form = $this->createForm(DossierMedicalType::class, $DossierMedical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $DossierMedicalRepository->save($DossierMedical, true);

            return $this->redirectToRoute('app_DossierMedical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('DossierMedical/new.html.twig', [
            'DossierMedical' => $DossierMedical,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_DossierMedical_show', methods: ['GET'])]
    public function show(DossierMedical $DossierMedical): Response
    {
        return $this->render('DossierMedical/show.html.twig', [
            'DossierMedical' => $DossierMedical,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_DossierMedical_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DossierMedical $DossierMedical, DossierMedicalRepository $DossierMedicalRepository): Response
    {
        $form = $this->createForm(DossierMedicalType::class, $DossierMedical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $DossierMedicalRepository->save($DossierMedical, true);

            return $this->redirectToRoute('app_DossierMedical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('DossierMedical/edit.html.twig', [
            'DossierMedical' => $DossierMedical,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_DossierMedical_delete', methods: ['POST'])]
    public function delete(Request $request, DossierMedical $DossierMedical, DossierMedicalRepository $DossierMedicalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$DossierMedical->getId(), $request->request->get('_token'))) {
            $DossierMedicalRepository->remove($DossierMedical, true);
        }

        return $this->redirectToRoute('app_DossierMedical_index', [], Response::HTTP_SEE_OTHER);
    }
   
}
