<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class AdminArticleController extends AbstractController
{
    #[Route("/admin/insert-article", name: "admin-insert-article")]
    public function insertArticle(EntityManagerInterface $entityManager, Request $request){

        /*$title = $request->query->get('title');
        $content = $request->query->get('content');
        $author = $request->query->get('author');

        if(!empty($title) &&
            !empty($content) &&
            !empty($author)
        ){*/
            //Création d'une instance de classe pour les articles(Classe entité)
            //Celle si servira à inclure mon nouvel article dans la base de données

            $article = new Article();

            $form = $this->createForm(ArticleType::class, $article);


            return $this->render('admin/form_article.html.twig', [
               'form' => $form->createView()
            ]);
            // Ici j'utilise mes setters afin de d'attribuer mes données
            // voulues pour le titre, le contenu etc..
            /*$article->setTitle($title);
            $article->setContent($content);
            $article->setIsPublished(true);
            $article->setAuthor($author);


            // La classe entityManagerInterface de doctrine me permets
            // d'enregisterer mon entité dans la bdd dans la table article.
            // en deux étapes avec les fonctions persist & flush.

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Votre article à bien été ajouté !');

            return $this->redirectToRoute('admin-articles');
        } else {
            $this->addFlash('error','Article non ajouté !');
        }
        return $this->render('admin/form_article.html.twig');*/
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

    #[Route("/admin/article/{id}", name: "admin-article")]
    public function article($id, ArticleRepository $articleRepository){
        $article = $articleRepository->find($id);
        return $this->render('admin/article.html.twig',[
            "article"=>$article
        ]);
    }

    // Crée une route pointant vers l'id de l4article permettant de supprimer le contenu selectionné
    // passant par l'entity manager et le repository comportant les caracteristiques des articles
    #[Route("/admin/article/delete/{id}", name: "admin-article-delete")]
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager){
        $article = $articleRepository->find($id);

        if(!is_null($article)){
            // La fonctionnalité remove efface l'élément selectionné
            $entityManager->remove($article);
            $entityManager->flush();
            // Le redirect to route permet de rediriger vers la page précédent la suppression
            // Le Addflash permet d'afficher un message avertissant si l'opération à
            // été menée à bien ou non
            $this->addFlash('success', 'Votre article à bien été supprimé !');
        } else {
            $this->addFlash('error', 'Article introuvable !');
        }

        return $this->redirectToRoute('admin-articles');

    }

    #[Route("/admin/article/update/{id}", name: "admin-article-update")]
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager){
       $article = $articleRepository->find($id);

       $article->setTitle("Nouveau titre");

       $entityManager->persist($article);
       $entityManager->flush();

       return $this->redirectToRoute('admin-articles');
    }

}