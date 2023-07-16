<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserNameFormType;
use App\Form\UserPasswordFormType;
use App\Security\UserAuthenticator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Page Profil
 */
#[Route('/profil', name: 'app_profil_')]
class ProfilController extends AbstractController
{
    /**
     * Page Profil, Index
     *
     * @return Response
     */    
    #[Route('', name: 'index', methods: ['GET', 'POST'])]
    public function profil(): Response
    {
        return $this->render('pages/profil/profil.html.twig');
    }

    /**
     * Page Profil, Edit Name
     *
     * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @return Response
     */    
    #[Route('/name/{id}', name: 'name', methods: ['GET', 'POST'])]
    public function profilName(Request $request, User $user, EntityManagerInterface $manager,
        UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(UserNameFormType::class, $user);
        $form->handleRequest($request);

        $oldPassword = $form->get('oldPassword')->getData();

        if ($form->isSubmitted() && $form->isValid() && $userPasswordHasher->isPasswordValid($user, $oldPassword))
        {
            $user->setUpdatedAt(new \DateTimeImmutable());
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Your name have been successfully edited !');
            return $this->redirectToRoute('app_profil_index');
        }

        else if ($form->isSubmitted() && !$form->isValid())
        {
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        else if ($form->isSubmitted() && !$userPasswordHasher->isPasswordValid($user, $oldPassword))
        {
            $this->addFlash('warning-old-password', 'Complete the following step and try again.');          
        }
        
        return $this->render('pages/profil/profil_name.html.twig', compact('form'));
    }
 
    /**
     * Page Profil, Edit Password
     *
     * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @return Response
     */
    #[Route('/password/{id}', name: 'password', methods: ['GET', 'POST'])]
    public function profilPassword(Request $request, User $user, EntityManagerInterface $manager,
        UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(UserPasswordFormType::class, $user);
        $form->handleRequest($request);

        $oldPassword = $form->get('oldPassword')->getData();

        if ($form->isSubmitted() && $form->isValid() && $userPasswordHasher->isPasswordValid($user, $oldPassword))
        {
            $user->setUpdatedAt(new \DateTimeImmutable());

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // DB

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Your password have been successfully edited !');
            return $this->redirectToRoute('app_profil_index');
        }

        else if ($form->isSubmitted() && !$form->isValid())
        {
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        else if ($form->isSubmitted() && !$userPasswordHasher->isPasswordValid($user, $oldPassword))
        {
            $this->addFlash('warning-old-password', 'Complete the following step and try again.');          
        }

        return $this->render('pages/profil/profil_password.html.twig', compact('form'));
    }

    /**
     * Page Profil, Delete Profil
     *
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function profilDelete(User $user, EntityManagerInterface $manager): Response
    {
        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('app_login');
    }
}