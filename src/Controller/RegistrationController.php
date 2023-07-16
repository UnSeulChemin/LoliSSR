<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * Page Register
 */
class RegistrationController extends AbstractController
{
    /**
     * Page Register, Create
     *
     * @param Request $request
     * @param UserAuthenticator $authenticator
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param UserAuthenticatorInterface $userAuthenticator
     * @param EntityManagerInterface $entityManager
     * @param MailerInterface $mailer
     * @return Response
     */
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserAuthenticator $authenticator, 
        UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, 
        EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        if ($this->getUser())
        {
            $this->addFlash('warning', 'You can\'t access to this page.');
            return $this->redirectToRoute('app_profil_index');
        }

        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // DB

            $entityManager->persist($user);
            $entityManager->flush();

            // Send Email, Just Saying Not Validate

            $email = (new TemplatedEmail())
            ->from('lolissr.noreply@gmail.com')
            ->to($user->getEmail())
            ->subject('Your registration to LoliSSR')
            ->htmlTemplate('pages/emails/emails_registration_confirm.html.twig')
            ->context([
                'user' => $user
            ]);

            $mailer->send($email);

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );

            // return $this->redirectToRoute('app_register');
        }

        else if ($form->isSubmitted() && !$form->isValid())
        {
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        return $this->render('pages/security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}