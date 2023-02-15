<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleRefController extends AbstractController
{
    #[Route('/register/role_ref', name: 'app_role_ref')]
    public function index(): Response
    {
        return $this->renderForm('home/submit_role.html.twig', [
            'controller_name' => 'RoleRefController',
        ]);
    }
}
