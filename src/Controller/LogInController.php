<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogInController extends AbstractController
{
    #[Route('/sign/in', name: 'app_sign_in')]
    public function index(): Response
    {
        return $this->render('home/submit_role.html.twig', [
            'controller_name' => 'LogInController',
        ]);
    }
}
