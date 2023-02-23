<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\TimeSlot;
use App\Entity\CalandarDay;
use App\Form\CalandarDayType;
use App\Form\TimeSlotType;
use App\Repository\UserRepository;
use App\Repository\CalandarDayRepository;
use App\Repository\TimeSlotRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/calandarday/access')]
class CalandarDayAccessController extends AbstractController
{



    // _*****/calandarday***app_calandar_day_index***list_all_calandar_for a doctor ***************

    #[Route('/{id}', name: 'app_calandar_access_day_index', methods: ['GET'])]
    public function index(User $id, CalandarDayRepository $calandarDayRepository, UserRepository $repoUser): Response
    {

        // if not logged in no place for him
        if ($this->getUser() === null)
            return $this->redirectToRoute("app_login");

        // excluding everyone excep a doctor or a nurse
        if (!in_array('ROLE_USER', $this->getUser()->getRoles(), true))
            return $this->redirectToRoute('error_404', [
                'errormsg' => "404-maybe-you-have-no-right-for-now"
            ]); // redirect to booking better

        // getting user 
        $userEmail = $this->getUser()->getUserIdentifier();
        $user = $repoUser->findOneBy(['email' => $userEmail]);

        return $this->render('calandar_day/index.html.twig', [
            'calandar_days' => $calandarDayRepository->findBy([
                "doctor" => $id  // getId is not an error
            ]),
            'doctor' => $id->getId(),
            'name' => $id->getLastName(),
            'user' => $id->getId(),

        ]);
    }


 
    // _****show ****/{id}*********  **app_calandar_day_show***************************


    #[Route('/{id}', name: 'app_calandar_day_show', methods: ['GET'])]
    public function show(CalandarDay $calandarDay): Response
    {

        return $this->render('calandar_day/show.html.twig', [
            'calandar_day' => $calandarDay,
        ]);
    }


    // _****/{id}/edit**********app_calandar_day_edit** *************

    #[Route('/{id}/edit', name: 'app_calandar_day_edit', methods: ['GET', 'POST'])]
    public function edit(CalandarDay $calandarDay, Request $request, CalandarDayRepository $calandarDayRepository): Response
    {
        // getting user from calandar wich is very cool
        $doctor = $calandarDay->getDoctor();
        $roles = $doctor->getRoles();

        dump($calandarDay);
        if ($this->getUser()->getUserIdentifier() !== $doctor->getEmail())
            return $this->redirectToRoute('error_404');
        if (!(in_array('ROLE_DOCTOR', $roles, true) || in_array('ROLE_Nurse', $roles, true)))
            return $this->redirectToRoute('error_404', [
                'errormsg' => "404 access-denied please avoid such behavior ."
            ]);


        $form = $this->createForm(CalandarDayType::class, $calandarDay, [
            'id' => $doctor
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calandarDayRepository->save($calandarDay, true);

            return $this->redirectToRoute('app_calandar_day_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('calandar_day/edit.html.twig', [
            'calandar_day' => $calandarDay,
            'form' => $form,
        ]);
    }


    // _*****/delete/{id}******* ****app_calandar_day_delete**************

    #[Route('/delete/{id}', name: 'app_calandar_day_delete', methods: ['POST'])]
    public function delete(Request $request, CalandarDay $calandarDay, CalandarDayRepository $calandarDayRepository): Response
    {
        // getting user from calandar wich is very cool
        $doctor = $calandarDay->getDoctor();
        $roles = $doctor->getRoles();

        dump($calandarDay);
        if ($this->getUser()->getUserIdentifier() !== $doctor->getEmail())
            return $this->redirectToRoute('error_404');
        //this is innecessary only when we grap user from the calandar in other situation not valid maybe
        if (!(in_array('ROLE_DOCTOR', $roles, true) || in_array('ROLE_Nurse', $roles, true)))
            return $this->redirectToRoute('error_404');

        if ($this->isCsrfTokenValid('delete' . $calandarDay->getId(), $request->request->get('_token'))) {
            $calandarDayRepository->remove($calandarDay, true);
        }

        return $this->redirectToRoute('app_calandar_day_index', [], Response::HTTP_SEE_OTHER);
    }
}
