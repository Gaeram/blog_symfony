<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class AdminArticleController extends AbstractController
{
    #[Route("/admin/insert-article", name: "admin-insert-article")]
    public function insertArticle(EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger){
        // Création d'un nouveau patron de formulaire avec bin/console make:form
        // Création du Type en le renomant par le nom de l'entité + type
        $article = new Article();
        // Création du formulaire en recuperant l'instance
        $form = $this->createForm(ArticleType::class, $article);
        //Renvoi du formulaire sur la page en twig via le biais de la fonction form

        // on donne à la variable qui contient le form
        // une instance de la classe request
        // pour que le form puisse récuperer toutes les données
        // des inputs et faire les setter automatiquement sur $category
        $form->handleRequest($request);

        //ici on note que si le contenu du formulaire est envoyé et est conforme
        // à ce qui est attendu en BDD, il sera pris en compte
        if($form->isSubmitted() && $form->isValid()){
            $image = $form->get('image')->getData();

            // Récup fichier original
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            // Utilise instance de classe slugger & sa methode slug pour
            // supprimer les caractères spéciaux
            $safeFilename = $slugger->slug($originalFilename);
            // Je rajoute au nom de l'image un, id unique
            // Au cas ou elle soit upload plusieurs fois
            $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
            // Déplace l'image dans le dossier public
            // en lui assignant en nouveau nom
            $image->move(
                $this->getParameter('images_directory'),
                $newFilename
            );

            $article->setImage($newFilename);

            $entityManager->persist($article);
            $entityManager->flush();
        }

        return $this->render('admin/form_article.html.twig', [
            'form' => $form->createView()
        ]);



        /*$title = $request->query->get('title');
        $content = $request->query->get('content');
        $author = $request->query->get('author');

        if(!empty($title) &&
            !empty($content) &&
            !empty($author)
        ){*/
            //Création d'une instance de classe pour les articles(Classe entité)
            //Celle si servira à inclure mon nouvel article.html.twig dans la base de données


            // Ici j'utilise mes setters afin de d'attribuer mes données
            // voulues pour le titre, le contenu etc..
            /*$article.html.twig->setTitle($title);
            $article.html.twig->setContent($content);
            $article.html.twig->setIsPublished(true);
            $article.html.twig->setAuthor($author);


            // La classe entityManagerInterface de doctrine me permets
            // d'enregisterer mon entité dans la bdd dans la table article.html.twig.
            // en deux étapes avec les fonctions persist & flush.

            $entityManager->persist($article.html.twig);
            $entityManager->flush();

            $this->addFlash('success', 'Votre article.html.twig à bien été ajouté !');

            return $this->redirectToRoute('admin-articles');
        } else {
            $this->addFlash('error','Article non ajouté !');
        }
        return $this->render('admin/form_article.html.twig');*/
    }



    #[Route("/admin/articles", name: "admin-articles")]
    public function showArticle(ArticleRepository $articleRepository){
        // Recuperer depuis la bdd un article.html.twig en fonction de son ID
        // SELECT $ FROM article.html.twig where id  = xxx
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
            $this->addFlash('success', 'Votre article.html.twig à bien été supprimé !');
        } else {
            $this->addFlash('error', 'Article introuvable !');
        }

        return $this->redirectToRoute('admin-articles');

    }

    #[Route("/admin/article/update/{id}", name: "admin-article-update")]
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger){
       $article = $articleRepository->find($id);

        // Création du formulaire en recuperant l'instance
        $form = $this->createForm(ArticleType::class, $article);
        //Renvoi du formulaire sur la page en twig via le biais de la fonction form

        // on donne à la variable qui contient le form
        // une instance de la classe request
        // pour que le form puisse récuperer toutes les données
        // des inputs et faire les setter automatiquement sur $category
        $form->handleRequest($request);

        // ici on note que si le contenu du formulaire est envoyé et est conforme
        // à ce qui est attendu en BDD, il sera pris en compte
        if($form->isSubmitted() && $form->isValid()){
            $image = $form->get('image')->getData();

            // Récup fichier original
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            // Utilise instance de classe slugger & sa methode slug pour
            // supprimer les caractères spéciaux
            $safeFilename = $slugger->slug($originalFilename);
            // Je rajoute au nom de l'image un, id unique
            // Au cas ou elle soit upload plusieurs fois
            $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
            // Déplace l'image dans le dossier public
            // en lui assignant en nouveau nom
            $image->move(
                $this->getParameter('images_directory'),
                $newFilename
            );

            $article->setImage($newFilename);



            $entityManager->persist($article);
            $entityManager->flush();
        }

        return $this->render('admin/update.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);

       /*$article.html.twig->setTitle("Nouveau titre");

       $entityManager->persist($article.html.twig);
       $entityManager->flush();

       return $this->redirectToRoute('admin-articles');*/
    }

    #[Route("/admin/articles/search", name: "admin-articles-search")]
    public function searchArticle(Request $request, ArticleRepository $articleRepository)
    {
        // Je récupère les valeurs de mon formulaire dans ma route
        $search = $request->query->get('search');

        // je vais créer une méthode dans mon Repository
        // Qui permet de retrouver du contenu enn fonction d'un mot
        // entré dans la barre de recherche
        $articles = $articleRepository->searchByWord($search);


        // Je renvoie un .twig en lui passant les articles trouvé
        // & les affiche
        return $this->render('admin/search_articles.html.twig', [
            'articles' => $articles
        ]);
    }

}