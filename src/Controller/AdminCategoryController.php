<?php

namespace App\Controller;

use App\Entity\ArticleCategory;
use App\Repository\ArticleCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminCategoryController extends AbstractController
{
    #[Route("/admin/insert-category", name: "admin-insert-category")]
    public function insertCategory(EntityManagerInterface $entityManager){

        // Appel de l'instance ArticleCategory dans une variable
        $category = new ArticleCategory();
        // Utilisation des setters afin de définir nos données
        $category->setTitle("Animaux");
        $category->setColor("White");
        $category->setDescription("Regroupe les articles sur le theme animalier");
        $category->setIsPublished(true);
        // Utilisation de ces deux fonctions appartenant à EntityManagerInterface
        // Pour les enregistrer dans la table dédié dans la bdd
        $entityManager->persist($category);
        $entityManager->flush();

        return $this->redirectToRoute('admin-articles');

    }


    #[Route("/admin/categories", name: "admin-categories")]
    public function listCategory(ArticleCategoryRepository $articleCategoryRepository){
        $category = $articleCategoryRepository->findAll();
        return $this->render('admin/categories.html.twig', [
            'category' => $category
        ]);
    }

    #[Route("/admin/categories/{id}", name: "admin-category")]
    public function showCategory($id, ArticleCategoryRepository $articleCategoryRepository){
        $category = $articleCategoryRepository->find($id);
        return $this->render('admin/category.html.twig', [
            'category' => $category
        ]);
    }

    // Crée une route pointant vers l'id de la catégorie permettant de supprimer le contenu selectionné
    // passant par l'entity manager et le repository comportant les caracteristiques des catégories
    #[Route("/admin/categories/delete/{id}", name: "admin-category-delete")]
    public function deleteCategory($id, ArticleCategoryRepository $articleCategoryRepository, EntityManagerInterface $entityManager){
        $category = $articleCategoryRepository->find($id);

        if(!is_null($category)){
            // La fonctionnalité remove efface l'élément selectionné
            $entityManager->remove($category);
            $entityManager->flush();

            // Le redirect to route permet de rediriger vers la page précédent la suppression
            return $this->redirectToRoute('admin-categories');
        } else {
            return new Response("Déja supprimée");
        }
    }

    #[Route("/admin/categories/update/{id}", name: "admin-categorie-update")]
    public function updateCategory($id, ArticleCategoryRepository $articleCategoryRepository, EntityManagerInterface $entityManager){
        $category = $articleCategoryRepository->find($id);

        $category->setTitle("Nouveau titre");

        $entityManager->persist($category);
        $entityManager->flush();

        return $this->redirectToRoute('admin-categories');
    }


}