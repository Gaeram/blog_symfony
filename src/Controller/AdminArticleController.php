<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isNull;


class AdminArticleController extends AbstractController
{
    #[Route("/admin/insert-article", name: "admin-insert-article")]
    public function insertArticle(EntityManagerInterface $entityManager){

        //Création d'une instance de classe pour les articles(Classe entité)
        //Celle si servira à inclure mon nouvel article dans la base de données

        $article = new Article();

        // Ici j'utilise mes setters afin de d'attribuer mes données
        // voulues pour le titre, le contenu etc..
        $article->setTitle("Chat mignon");
        $article->setContent("ouuuh qu'il est troumignoninou ce petit chat. Et si je lui roulais dessus avec mon SUV");
        $article->setIsPublished(true);
        $article->setAuthor("Moi même");


        // La classe entityManagerInterface de doctrine me permets
        // d'enregisterer mon entité dans la bdd dans la table article.
        // en deux étapes avec les fonctions persist & flush.

        $entityManager->persist($article);
        $entityManager->flush();

        dump($article);
        die();
    }


    #[Route("/admin/articles", name: "admin-articles")]
    public function showArticle(ArticleRepository $articleRepository){
        // Recuperer depuis la bdd un article en fonction de son ID
        // SELECT $ FROM article where id  = xxx
        $article = $articleRepository->findAll();
        // La classe repository me permet de faire des SELECT
        // Dans la table qui y est associée
        // Cette methode permet la recuperation du element via son id
        return $this->render('admin/lists.html.twig', [
            "article"=>$article
        ]);
    }

    #[Route('/admin/article/{id}', name: 'admin-article')]
    public function article($id, ArticleRepository $articleRepository){
        $article = $articleRepository->find($id);
        return $this->render('admin/article.html.twig',[
            "article"=>$article
        ]);
    }

    #[Route('/admin/article/delete/{id}', name: 'admin-article-delete')]
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager){
        $article = $articleRepository->find($id);

        if(!is_null($article)){
            $entityManager->remove($article);
            $entityManager->flush();

            return new Response("Article supprimé");
        } else {
            return new Response("Déja supprimé");
        }
    }

    #[Route('/admin/article/update/{id}', name: "admin-article-update")]
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager){
       $article = $articleRepository->find($id);

       $article->setTitle("Nouveau titre");

       $entityManager->persist($article);
       $entityManager->flush();

       return new Response("Élement mis à jour");
    }

}