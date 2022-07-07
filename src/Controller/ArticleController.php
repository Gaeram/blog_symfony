<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
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


    #[Route("show-article", name: "show-article")]
    public function showArticle(ArticleRepository $articleRepository){
        // Recuperer depuis la bdd un article en fonction de son ID
        // SELECT $ FROM article where id  = xxx
        $artcle = $articleRepository->find(1);
        // La classe repository me permet de faire des SELECT
        // Dans la table qui y est associée
        // Cette methode permet la recuperation du element via son id
        dd($artcle);
    }




    #[Route('/lists', name: 'lists')]
    public function lists(){
        $lists = [
            1 => [
                'title' => 'Non, là c\'est sale',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Eric',
                'image' => 'https://media.gqmagazine.fr/photos/5b991bbe21de720011925e1b/master/w_780,h_511,c_limit/la_tour_montparnasse_infernale_1893.jpeg',
                'id' => 1
            ],
            2 => [
                'title' => 'Il faut trouver tous les gens qui étaient de dos hier',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Maurice',
                'image' => 'https://fr.web.img6.acsta.net/r_1280_720/medias/nmedia/18/35/18/13/18369680.jpg',
                'id' => 2

            ],
            3 => [
                'title' => 'Pluuutôôôôt Braaaaaach, Vasarelyyyyyy',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Didier',
                'image' => 'https://media.gqmagazine.fr/photos/5eb02109566df9b15ae026f3/master/pass/n-3freres.jpg',
                'id' => 3

            ],
            4 => [
                'title' => 'Quand on attaque l\'empire, l\'empire contre attaque',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Mbala',
                'image' => 'https://fr.web.img2.acsta.net/newsv7/21/01/20/15/49/5077377.jpg',
                'id' => 4

            ],
        ];

        return $this->render('lists.html.twig', [
            'lists' => $lists
        ]);
    }

    #[Route('/article/{id}', name: 'article')]
    public function article($id)
    {
        $lists = [
            1 => [
                'title' => 'Non, là c\'est sale',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Eric',
                'image' => 'https://media.gqmagazine.fr/photos/5b991bbe21de720011925e1b/master/w_780,h_511,c_limit/la_tour_montparnasse_infernale_1893.jpeg',
                'id' => 1
            ],
            2 => [
                'title' => 'Il faut trouver tous les gens qui étaient de dos hier',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Maurice',
                'image' => 'https://fr.web.img6.acsta.net/r_1280_720/medias/nmedia/18/35/18/13/18369680.jpg',
                'id' => 2

            ],
            3 => [
                'title' => 'Pluuutôôôôt Braaaaaach, Vasarelyyyyyy',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Didier',
                'image' => 'https://media.gqmagazine.fr/photos/5eb02109566df9b15ae026f3/master/pass/n-3freres.jpg',
                'id' => 3

            ],
            4 => [
                'title' => 'Quand on attaque l\'empire, l\'empire contre attaque',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Mbala',
                'image' => 'https://fr.web.img2.acsta.net/newsv7/21/01/20/15/49/5077377.jpg',
                'id' => 4

            ],
        ];

        return $this->render('article.html.twig', [
            'list'=>$lists[$id]
        ]);
    }

}