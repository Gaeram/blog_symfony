<?php

namespace App\Controller;

use App\Entity\ArticleCategory;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Repository\ArticleCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    #[Route("/admin/insert-category", name: "admin-insert-category")]
    public function insertCategory(EntityManagerInterface $entityManager, Request $request){
        // Création d'un nouveau patron de formulaire avec bin/console make:form
        // Création du Type en le renomant par le nom de l'entité + type
        $category = new ArticleCategory();
        // Création du formulaire en recuperant l'instance
        $form = $this->createForm(CategoryType::class, $category);
        //Renvoi du formulaire sur la page en twig via le biais de la fonction form.
        return $this->render('admin/form_category.html.twig', [
            'form' => $form->createView()
        ]);
        /*$title = $request->query->get('title');
        $description = $request->query->get('description');
        $color = $request->query->get('color');
        if(!empty($title) &&
            !empty($description)&&
            !empty($color)
        ) {

            ]);
            // Récupère l'instance ArticleCategory dans une variable


            // Utilisation des setters afin de définir nos données
            $category->setTitle($title);
            $category->setDescription($description);
            $category->setColor($color);
            $category->setIsPublished(true);
            // Utilisation de ces deux fonctions appartenant à EntityManagerInterface
            // Pour les enregistrer dans la table dédié dans la bdd
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'votre catégorie à bien été ajoutée ');

            return $this->redirectToRoute('admin-categories');
        } else {
            $this->addFlash('error', 'Merci de remplir le titre et le contenu !');
        }
        return $this->render('admin/form_category.html.twig');*/
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

            // addflash affichant le succes ou non de la procédure
            $this->addFlash('success', 'Votre catégorie à bien été supprimée !');
        } else {
            $this->addFlash('error', 'Catégorie introuvable !');
        }
        return $this->redirectToRoute('admin-categories');

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