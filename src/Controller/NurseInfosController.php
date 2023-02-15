<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NurseInfosController extends AbstractController
{
    #[Route('/nurse/infos', name: 'app_nurse_infos')]
    public function index(): Response
    {
        return $this->render('nurse_infos/index.html.twig', [
            'controller_name' => 'NurseInfosController',
        ]);
    }
}
