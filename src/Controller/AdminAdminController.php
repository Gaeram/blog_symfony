<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminAdminController extends AbstractController
{
    #[Route('/admin/admins', name: 'admin-list-admins')]
    public function listAdmins(UserRepository $userRepository){

        $admins = $userRepository->findAll();

        return $this->render('admin/admins.html.twig', [
                'admins'=>$admins
            ]);
    }

    #[Route('/admin/create', name: 'admin-create-admin')]
    public function createAdmin(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher){

        $user = new User();
        $user->setRoles(["ROLE_ADMIN"]);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->IsSubmitted() && $form->isValid()){

            $plainPassword = $form->get('password')->getData();
            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);

            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('sucess', 'L/admin à été créé avec succès');

            return $this->redirectToRoute('admin-list-admins');

        }

        return $this->render('admin/insert_admin.html.twig', [

            'form'=>$form->createView()
        ]);
    }

}