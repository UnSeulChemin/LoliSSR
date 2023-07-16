<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Page List
 */
#[Route('/list', name: 'app_list_')]
class ListController extends AbstractController
{
    /**
     * Page List, Index
     *
     * @return Response
     */    
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/list/list.html.twig');
    }
}