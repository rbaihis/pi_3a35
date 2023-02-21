<?php

namespace App\Controller;

use App\Entity\EventTicket;
use App\Form\EventTicketType;
use App\Repository\EventTicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/events/ticket')]
class EventsTicketController extends AbstractController
{
    #[Route('/', name: 'app_events_ticket_index', methods: ['GET'])]
    public function index(EventTicketRepository $eventTicketRepository): Response
    {
        return $this->render('events_ticket/index.html.twig', [
            'event_tickets' => $eventTicketRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_events_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EventTicketRepository $eventTicketRepository): Response
    {
        $eventTicket = new EventTicket();
        $form = $this->createForm(EventTicketType::class, $eventTicket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventTicketRepository->save($eventTicket, true);

            return $this->redirectToRoute('app_events_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('events_ticket/new.html.twig', [
            'event_ticket' => $eventTicket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_events_ticket_show', methods: ['GET'])]
    public function show(EventTicket $eventTicket): Response
    {
        return $this->render('events_ticket/show.html.twig', [
            'event_ticket' => $eventTicket,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_events_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EventTicket $eventTicket, EventTicketRepository $eventTicketRepository): Response
    {
        $form = $this->createForm(EventTicketType::class, $eventTicket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventTicketRepository->save($eventTicket, true);

            return $this->redirectToRoute('app_events_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('events_ticket/edit.html.twig', [
            'event_ticket' => $eventTicket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_events_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, EventTicket $eventTicket, EventTicketRepository $eventTicketRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventTicket->getId(), $request->request->get('_token'))) {
            $eventTicketRepository->remove($eventTicket, true);
        }

        return $this->redirectToRoute('app_events_ticket_index', [], Response::HTTP_SEE_OTHER);
    }
}
