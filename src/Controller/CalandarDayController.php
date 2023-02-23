<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\TimeSlot;
use App\Entity\CalandarDay;
use App\Form\CalandarDayType;
use App\Form\TimeSlotType;
use App\Repository\AppointmentRepository;
use App\Repository\UserRepository;
use App\Repository\CalandarDayRepository;
use App\Repository\TimeSlotRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/calandarday')]
class CalandarDayController extends AbstractController
{



    // _*****/calandarday***app_calandar_day_index***list_all_calandar_for a doctor ***************

    #[Route('/', name: 'app_calandar_day_index', methods: ['GET'])]
    public function index(CalandarDayRepository $calandarDayRepository, UserRepository $repoUser): Response
    {

        // if not logged in no place for him
        if ($this->getUser() === null)
            return $this->redirectToRoute("app_login");

        // excluding everyone excep a doctor or a nurse
        if (!(in_array('ROLE_DOCTOR', $this->getUser()->getRoles(), true) || in_array('ROLE_Nurse', $this->getUser()->getRoles(), true)))
            return $this->redirectToRoute('error_404', [
                'errormsg' => "404-maybe-you-have-no-right-for-now"
            ]); // redirect to booking better

        // getting user 
        $userEmail = $this->getUser()->getUserIdentifier();
        $user = $repoUser->findOneBy(['email' => $userEmail]);

        return $this->render('calandar_day/index.html.twig', [
            'calandar_days' => $calandarDayRepository->findBy([
                "doctor" => $user->getId()  // getId is not an error
            ]),
            'doctor' => $user->getId(),
            'name' => $user->getLastName()

        ]);
    }


    // _******/new/{doctor} *********app_calandar_day_new*****************

    #[Route('/new/{doctor}', name: 'app_calandar_day_new', methods: ['GET', 'POST'], requirements: ['doctor' => '\d+'])]
    public function new(User $doctor, Request $request, CalandarDayRepository $calandarDayRepository, TimeSlotRepository $repoTs): Response
    {

        dump($doctor);
        $roles = $doctor->getRoles();

        if ($this->getUser()->getUserIdentifier() !== $doctor->getEmail())
            return $this->redirectToRoute('error_404');
        if (!(in_array('ROLE_DOCTOR', $roles, true) || in_array('ROLE_Nurse', $roles, true)))
            return $this->redirectToRoute('error_404', [
                'errormsg' => "404 access-denied please avoid such behavior ."
            ]);

        $calandarDay = new CalandarDay();
        $form = $this->createForm(CalandarDayType::class, $calandarDay, [
            // passing default objects to be rendered on the form from the start , option must be defined on EntityType
            // must define the attribute in EntityType on the configureOptions() function to be accepted
            'id' => $doctor, // ['id'=>$id] //important to pass user to the form
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calandarDay->setDoctor($doctor);
            try {
                $calandarDayRepository->save($calandarDay, true);
            } catch (UniqueConstraintViolationException $e) {
                $this->addFlash('error', 'Error: cant create 2 calandars on the same day');
                return $this->redirectToRoute('app_calandar_day_new', [
                    'calandar_day' => $calandarDay,
                    'form' => $form,
                    // 'id' => $doctor,
                    'doctor' => $doctor->getId(),
                ]);
            }


            $startAt = new  \DateTime($calandarDay->getDayStart()->format('H:i'));
            $endAt = new  \DateTime($calandarDay->getDayEnd()->format('H:i'));
            $interval = new \DateInterval('PT' . $calandarDay->getSessionDuration() . 'M');
            $current = clone $startAt;
            $lunchStart =  new  \DateTime($calandarDay->getLunchBreakStart()->format('H:i'));;
            $lunchEnd = new  \DateTime($calandarDay->getLunchBreakEnd()->format('H:i'));
            dump($startAt, $endAt, $interval, $current, $lunchStart, $lunchEnd);
            $msg_from_time_slot = "TimeSlot not created.";
            while ($current < $endAt) {
                $slotStart = clone $current;
                $slot = new TimeSlot();
                $slot->setCalandarDay($calandarDay); // filling slot.calandar_id object whith Calandar object
                $slot->setStartTime($slotStart);
                $slot->setStatus("available");
                if ($current >= $lunchStart && $current < $lunchEnd) {
                    $slot->setStatus("not-available");
                    $slot->setReason("lunch-time");
                    // dump($slot->getStartTime());
                    $current->add($lunchStart->diff($lunchEnd));
                    // dd($current);
                } else {
                    $current->add($interval); // adding interval to that time
                    $slot->setReason("unbooked");
                }
                $slotEnd = clone $current;
                $slot->setEndTime($slotEnd);

                $repoTs->save($slot, true);
                $msg_from_time_slot = " created .";
            }

            return $this->redirectToRoute(
                'app_calandar_day_index',
                [
                    'id' => $calandarDay->getId()
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('calandar_day/new.html.twig', [
            'calandar_day' => $calandarDay,
            'form' => $form,
            'id' => $doctor
        ]);
    }


    // _****show ****/{id}*********  **app_calandar_day_show***************************


    #[Route('/{id}', name: 'app_calandar_day_show', methods: ['GET'])]
    public function show(CalandarDay $calandarDay, AppointmentRepository $repoAppoint): Response
    {
        $roles = $this->getUser()->getRoles();
        $role = null;
        if (count($roles) === 1 && $roles[0] === "ROLE_USER")
            $role = "ROLE_USER";
        if ((in_array('ROLE_DOCTOR', $roles, true) || in_array('ROLE_Nurse', $roles, true)))
            $role = "ROLE_DOCTOR";

        $appointments = $repoAppoint->createQueryBuilder('a')
            ->leftJoin('a.timeSlot', 't')
            ->where('t.calandarDay = :calandarDay')
            ->setParameter('calandarDay', $calandarDay->getId())
            ->getQuery()
            ->getResult();

        // dd($appointments);
        return $this->render('calandar_day/show.html.twig', [
            'calandar_day' => $calandarDay,
            'role' => $role,
            'appointments' => $appointments
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
