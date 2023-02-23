<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\TimeSlot;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use App\Repository\TimeSlotRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/appointment/user')]
class AppointmentController extends AbstractController
{
    #[Route('/', name: 'app_appointment_index', methods: ['GET'])]
    public function index(AppointmentRepository $appointmentRepository, UserRepository $repoUser): Response
    {
        $email = $this->getUser()->getUserIdentifier();
        $user = $repoUser->findOneBy(['email' => $email]);
        if (count($user->getRoles()) === 1 && $user->getRoles()[0] === "ROLE_USER")
            $appointments = $appointmentRepository->findby(['patient' => $user->getId()]);
        if ((in_array('ROLE_DOCTOR', $user->getRoles(), true) || in_array('ROLE_Nurse', $user->getRoles(), true)))
            $appointments = $appointmentRepository->findby(['doctor' => $user->getId()]);


        return $this->render('appointment/index.html.twig', [
            'appointments' => $appointments,
        ]);
    }

    //only user can do this 
    #[Route('/new/{id}', name: 'app_appointment_new', methods: ['GET', 'POST'])]
    public function new(TimeSlot $id, Request $request, AppointmentRepository $appointmentRepository, UserRepository $repoUser, TimeSlotRepository $repTimeSlot): Response
    {
        // relationship
        $email = $this->getUser()->getUserIdentifier();
        $user = $repoUser->findOneBy(['email' => $email]);
        $calandar = $id->getCalandarDay();
        $doctor = $calandar->getDoctor();

        $appointment = new Appointment();
        $form = $this->createForm(AppointmentType::class, $appointment, [
            'user_id' => $user->getId(),
            'doctor_id' => $doctor->getId(),
            'time_slot_id' => $id->getId(),
            'date_app' => $calandar->getDate(),
            'time_app' => $id->getStartTime(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // appointment filling up
            $appointment->setDate($calandar->getDate());
            $appointment->setHour($id->getStartTime());
            $appointment->setDoctor($doctor);
            $appointment->setPatient($user);
            $appointment->setTimeSlot($id);
            $appointmentRepository->save($appointment, true);
            // updating slot status
            $id->setStatus('not-available');
            $id->setReason('booked');
            $repTimeSlot->save($id, true);

            return $this->redirectToRoute('app_calandar_access_day_index', [
                'id' => $doctor->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appointment/new.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
            'id' => $doctor->getId(),
        ]);
    }

    #[Route('/{id}', name: 'app_appointment_show', methods: ['GET'])]
    public function show(Appointment $appointment): Response
    {
        return $this->render('appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_appointment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appointment $appointment, AppointmentRepository $appointmentRepository): Response
    {
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appointmentRepository->save($appointment, true);

            return $this->redirectToRoute('app_appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appointment/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_appointment_delete', methods: ['POST'])]
    public function delete(Request $request, Appointment $appointment, AppointmentRepository $appointmentRepository, TimeSlotRepository $repoTImeSlot): Response
    {

        if ($this->isCsrfTokenValid('delete' . $appointment->getId(), $request->request->get('_token'))) {
            $timeSlot = $appointment->getTimeSlot();
            $appointmentRepository->remove($appointment, true);

            $timeSlot->setStatus('available');
            $timeSlot->setReason('unbooked');
            $repoTImeSlot->save($timeSlot, true);
        }

        return $this->redirectToRoute('app_appointment_index', [], Response::HTTP_SEE_OTHER);
    }
}
