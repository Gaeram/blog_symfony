<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
    #[Route("/insert-article", name: "insert-article")]
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
}