<?php

namespace App\Controller;

use App\Repository\ArticleCategoryRepository;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController

{
    #[Route('/', name: 'home')]
    public function home(ArticleRepository $articleRepository)
    {


        //Using instance to indexing articles
        $lastArticles = $articleRepository->findBy([], ['id' => 'DESC'], 3);

        return $this->render('home.html.twig', [
            'lastArticles' => $lastArticles
        ]);
    }

    #[Route('/articles', name: 'articles')]
    public function articles(ArticleRepository $articleRepository){

        $articles = $articleRepository->findAll();

        return $this->render('articles.html.twig', [
            'article'=>$articles
        ]);

    }

    #[Route('/article/{id}', name: 'article')]
    public function article(ArticleRepository $articleRepository, $id){

        $article = $articleRepository->findBy($id);

        return $this->render('article.html.twig', [
            'article'=>$article
        ]);
    }


    #[Route('/categories', name: 'categories')]
    public function categories(ArticleCategoryRepository $articleCategoryRepository){

        $categories = $articleCategoryRepository->findAll();

        return $this->render('categories.html.twig', [
            'category'=>$categories
        ]);
    }

    #[Route('/category/{id}', name: 'category')]
    public function category(ArticleCategoryRepository $articleCategoryRepository, $id){

        $category = $articleCategoryRepository->findBy($id);

        return $this->render('category.html.twig', [
            'category' => $category
        ]);
    }


}
