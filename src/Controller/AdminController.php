<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Contact;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use App\Repository\ContactRepository;
use App\Form\Edit\UserEditFormType;
use App\Form\Edit\ImageEditFormType;
use App\Form\Edit\ContactEditFormType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Page Admin
 */
#[Route('/admin', name: 'app_admin_')]
class AdminController extends AbstractController
{
    /**
     * Page Admin, Index
     *
     * @return Response
     */
    #[Route('', name: 'index')]
    public function admin(): Response
    {
        return $this->render('pages/admin/admin.html.twig');
    }

    /**
     * Page Admin, Read Images
     *
     * @param ImageRepository $repository
     * @return Response
     */
    #[Route('/images', name: 'images', methods: ['GET'])]
    public function readImages(ImageRepository $repository): Response
    {
        $images = $repository->findBy([], ['id' => 'DESC']);

        return $this->render('pages/admin/admin_images.html.twig', compact('images'));
    }

    /**
     * Page Admin, Edit Image
     *
     * @param Request $request
     * @param Image $image
     * @param EntityManagerInterface $manager
     * @return Response
     */    
    #[Route('/images/edit/{id}', name: 'images_edit', methods: ['GET', 'POST'])]
    public function editImages(Request $request, Image $image, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ImageEditFormType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $image = $form->getData();

            $manager->persist($image);
            $manager->flush();

            return $this->redirectToRoute('app_admin_images');
        }

        return $this->render('pages/admin/admin_images_edit.html.twig', compact('form'));
    }

     /**
     * Page Admin, Delete Image
     *
     * @param Image $image
     * @param EntityManagerInterface $manager
     * @return Response
     */   
    #[Route('/images/delete/{id}', name: 'images_delete', methods: ['GET'])]
    public function deleteImage(Image $image, EntityManagerInterface $manager): Response
    {
        $manager->remove($image);
        $manager->flush();

        $this->addFlash('success', 'The image have been successfully delete !');
        return $this->redirectToRoute('app_admin_images');
    }

    /**
     * Page Admin, Read Users
     *
     * @param UserRepository $repository
     * @return Response
     */
    #[Route('/users', name: 'users', methods: ['GET'])]
    public function readUsers(UserRepository $repository): Response
    {
        $users = $repository->findBy([], ['id' => 'DESC']);

        return $this->render('pages/admin/admin_users.html.twig', compact('users'));
    }

    /**
     * Page Admin, Edit Users
     *
     * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/users/edit/{id}', name: 'users_edit', methods: ['GET', 'POST'])]
    public function editUsers(Request $request, User $user, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserEditFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setUpdatedAt(new \DateTimeImmutable());
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render('pages/admin/admin_users_edit.html.twig', compact('form'));
    }

    /**
     * Page Admin, Delete Users
     *
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/users/delete/{id}', name: 'users_delete', methods: ['GET'])]
    public function deleteUsers(User $user, EntityManagerInterface $manager): Response
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', 'The user have been successfully delete !');
        return $this->redirectToRoute('app_admin_users');
    }

    /**
     *  Page Admin, Read Contacts
     *
     * @param ContactRepository $repository
     * @return Response
     */
    #[Route('/contacts', name: 'contacts', methods: ['GET'])]
    public function readContacts(ContactRepository $repository): Response
    {
        $contacts = $repository->findBy([], ['id' => 'DESC']);

        return $this->render('pages/admin/admin_contacts.html.twig', compact('contacts'));
    }

    #[Route('/contacts/edit/{id}', name: 'contacts_edit', methods: ['GET', 'POST'])]
    /**
     *  Page Admin, Edit Contact
     *
     * @param Request $request
     * @param Contact $contact
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function editContacts(Request $request, Contact $contact, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ContactEditFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $contact = $form->getData();

            $manager->persist($contact);
            $manager->flush();

            return $this->redirectToRoute('app_admin_contacts');
        }

        return $this->render('pages/admin/admin_contacts_edit.html.twig', compact('form'));
    }

    /**
     * Page Admin, Delete Contact
     *
     * @param Contact $contact
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/contacts/delete/{id}', name: 'contacts_delete', methods: ['GET'])]
    public function deleteContacts(Contact $contact, EntityManagerInterface $manager): Response
    {
        $manager->remove($contact);
        $manager->flush();

        $this->addFlash('success', 'The contact have been successfully delete !');
        return $this->redirectToRoute('app_admin_contacts');
    }

    /**
     * Page Admin, Read Admins
     *
     * @param UserRepository $repository
     * @return Response
     */    
    #[Route('/admins', name: 'admins', methods: ['GET'])]
    public function readAdmins(UserRepository $repository): Response
    {
        // Find By Roles, UserRepository Function
        $admins = $repository->findByRoles("ROLE_ADMIN");

        return $this->render('pages/admin/admin_admins.html.twig', compact('admins'));
    }

    /**
     * Page Admin, Delete Admins
     *
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/admins/delete/{id}', name: 'admins_delete', methods: ['GET'])]
    public function deleteAdmins(User $user, EntityManagerInterface $manager): Response
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', 'The admin have been successfully delete !');
        return $this->redirectToRoute('app_admin_admins');
    }

    /**
     * Page Admin, Read Data
     *
     * @param UserRepository $user_repo
     * @param ContactRepository $contact_repo
     * @param ImageRepository $image_repo
     * @return Response
     */    
    #[Route('/data', name: 'data', methods: ['GET'])]
    public function readData(UserRepository $user_repo, ContactRepository $contact_repo, ImageRepository $image_repo): Response
    {
        $users = $user_repo->findAll();
        $contacts = $contact_repo->findAll();
        $images = $image_repo->findAll();

        // Find By Roles, UserRepository Function
        $admins = $user_repo->findByRoles("ROLE_ADMIN");

        return $this->render('pages/admin/admin_data.html.twig', compact('users', 'admins', 'contacts', 'images'));
    }    
}