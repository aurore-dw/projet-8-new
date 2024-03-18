<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

#[Route('/users')]
class UserController extends AbstractController
{
    // Affiche la liste des utilisateurs
    #[Route('/', name: 'user_list', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    // Créer un nouvel utilisateur
    #[Route('/create', name: 'user_create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupére les rôles sélectionnés
            $selectedRoles = $form->get('roles')->getData();
            // On vérifie si $selectedRoles est un tableau
            $selectedRoles = is_array($selectedRoles) ? $selectedRoles : [$selectedRoles];
            // Assigne le rôle choisi à l'utilisateur
            $user->setRoles($selectedRoles);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/create.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // Modifie les données de l'utilisateur
    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function editAction(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupére les rôles sélectionnés
            $selectedRoles = $form->get('roles')->getData();
            // On vérifie si $selectedRoles est un tableau
            $selectedRoles = is_array($selectedRoles) ? $selectedRoles : [$selectedRoles];
            // Assigne le rôle choisi à l'utilisateur
            $user->setRoles($selectedRoles);

            $entityManager->flush();

            return $this->redirectToRoute('user_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}
