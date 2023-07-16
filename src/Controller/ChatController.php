<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Repository\ChatRepository;
use App\Form\ChatFormType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Page Chat
 */
#[Route('/chat', name: 'app_chat_')]
class ChatController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET', 'POST'])]
    public function chat(ChatRepository $repository, Request $request, EntityManagerInterface $manager): Response
    {
        $chat = new Chat();

        // Relation ManyToOne, GetUserId
        $chat->setUser($this->getUser());
        $chat->setName($this->getUser()->getName());

        $form = $this->createForm(ChatFormType::class, $chat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $chat = $form->getData();

            $manager->persist($chat);
            $manager->flush();

            return $this->redirectToRoute('app_chat_index');
        }

        $chats = $repository->findBy([], ['id' => 'DESC']);

        return $this->render('pages/chat/chat.html.twig', compact('chats', 'form'));
    }

    #[Route('/loop', name: 'loop', methods: ['GET', 'POST'])]
    public function chatLoop(ChatRepository $repository)
    {
        $chats = $repository->findBy([], ['id' => 'DESC']);

        return $this->render('pages/chat/chat_loop.html.twig', compact('chats'));
    }
}