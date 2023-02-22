<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/teste')]
class EventFrontController extends AbstractController
{
    #[Route('/', name: 'app_event_show', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event_show/index1.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }
}
