<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserInfosController extends AbstractController
{
    #[Route('/user/infos', name: 'app_user_infos')]
    public function index(): Response
    {
        return $this->render('user_infos/index.html.twig', [
            'controller_name' => 'UserInfosController',
        ]);
    }
}
