<?php

namespace App\Controller;
use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/articles/{id}/commentaires')]
class CommentaireController extends AbstractController
{

    #[Route('/new', name: 'app_commentaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Article $article, CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = new Commentaire();
        $commentaire->setArticle($article);
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaireRepository->save($commentaire, true);

            return $this->redirectToRoute('app_article_show', [
                'id'=>$article->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }



   
}
