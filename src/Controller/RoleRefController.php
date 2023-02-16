<?php

/*namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleRefController extends AbstractController
{
    #[Route('/register/role_ref', name: 'app_role_ref')]
    public function index(User $user): Response
    {
        return $this->renderForm('home/submit_role.html.twig', [
            'controller_name' => 'RoleRefController',
            'user'=>$user,
        ]);
    }
}
*/
// src/Controller/RoleRefController.php
namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleRefController extends AbstractController
{
    /**
     * @Route("/user/{userId}", name="role_ref_show", methods={"GET"})
     */
    public function show(Request $request,$id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->renderForm('home/submit_role.html.twig.html.twig', [
            'controller_name' => 'RoleRefController',
            'user'=>$user,
        ]);
    }


}
