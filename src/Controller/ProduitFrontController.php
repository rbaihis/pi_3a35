<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Entity\Categorie;


class ProduitFrontController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/produitfront', name: 'app_produitfront', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository,CategorieRepository $categorieRepository): Response
    {

        $categories = $this->entityManager->getRepository(Categorie::class)->findAll();

        return $this->render('produitfront/index.html.twig' , [
            'produits' => $produitRepository->findAll(),
            'categories' => $categories,

        ]);
    }

    #[Route('/fetch/{id}', name: 'app_produitfront_fetch')]
    public function show(Produit $produit): Response
    {
        return $this->render('produitfront/descriptionProduit.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/category/{id}', name: 'app_produitfront_category')]
    public function Category(Categorie $categorieSS): Response
    {
        $produits = $categorieSS->getProduits();

        return $this->render('produitfront/produitparcategorie.html.twig', [
            'produits' => $produits,
            'categorie' =>$categorieSS,

        ]);
    }

}
