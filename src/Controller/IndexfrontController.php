<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexfrontController extends AbstractController
{
    #[Route('/indexfront', name: 'app_indexfront')]
    public function index(): Response
    {
        return $this->render('indexfront/index.html.twig', [
            'controller_name' => 'IndexfrontController',
        ]);
    }
}
