<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DoctorInfosController extends AbstractController
{
    #[Route(path:'/doctor/infos', name: 'app_doctor_infos')]
    public function index(): Response
    {
        return $this->render('doctor_infos/index.html.twig', [
            'controller_name' => 'DoctorInfosController',
        ]);
    }
}
