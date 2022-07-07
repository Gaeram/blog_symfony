<?php

namespace App\Controller;

use App\Entity\ArticleCategory;
use App\Repository\ArticleCategoryRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route("/insert-category", name: "insert-category")]
    public function insertCategory(EntityManagerInterface $entityManager){

        // Appel de l'instance ArticleCategory dans une variable
        $category = new ArticleCategory();
        // Utilisation des setters afin de définir nos données
        $category->setTitle("Animaux");
        $category->setColor("Blue");
        $category->setDescription("Regroupe les articles sur le theme animalier");
        $category->setIsPublished(true);
        // Utilisation de ces deux fonctions appartenant à EntityManagerInterface
        // Pour les enregistrer dans la table dédié dans la bdd
        $entityManager->persist($category);
        $entityManager->flush();

        dump($category);
        die();

    }


    #[Route("/show-category", name: "show-category")]
    public function showCategory(ArticleCategoryRepository $articleCategoryRepository){
        $category = $articleCategoryRepository->find(1);
        dd($category);
    }

}