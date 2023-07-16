<?php

namespace App\Controller;

use App\Repository\ImageRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

/**
 *  Page Main
 */
#[Route('/', name: 'app_main_')]
class MainController extends AbstractController
{
    /**
     * Page Main, Read Image
     *
     * @param Request $request
     * @param ImageRepository $image
     * @param PaginatorInterface $paginator
     * @return Response
     */    
    #[Route('', name: 'index', methods: ['GET'])]
    public function main(Request $request, ImageRepository $image, PaginatorInterface $paginator): Response
    {
        $images = $paginator->paginate(
            $image->findBy([], ['id' => 'DESC']),
            // $request->query->getInt('page', 1), /*page number*/ 8 /*limit per page*/
            $number ?? 1, /*page number*/ 8 /*limit per page*/
        );

        return $this->render('pages/main.html.twig', compact('images')); 
    }

    /**
     * Page Main, Read Image, Paginate, Number
     *
     * @param integer $number
     * @param Request $request
     * @param ImageRepository $image
     * @param PaginatorInterface $paginator
     * @return Response
     */
    #[Route('/page/{number}', name: 'loli', methods: ['GET'])]
    public function mainPaginate(int $number, Request $request, ImageRepository $image, PaginatorInterface $paginator): Response
    {
        $images = $paginator->paginate(
            $image->findBy([], ['id' => 'DESC']),
            // $request->query->getInt('page', 1), /*page number*/ 8 /*limit per page*/
            $number ?? 1, /*page number*/ 8 /*limit per page*/
        );

        return $this->render('pages/main.html.twig', compact('images')); 
    }

    /**
     * Page Main, Read Image, Paginate, Type, Number
     *
     * @param integer $number
     * @param string $type
     * @param Request $request
     * @param ImageRepository $image
     * @param PaginatorInterface $paginator
     * @return Response
     */
    #[Route('/type/{type}/page/{number}', name: 'loli_type', methods: ['GET'])]
    public function typePaginate(int $number, string $type, Request $request, ImageRepository $image, PaginatorInterface $paginator): Response
    {
        $images = $paginator->paginate(
            $image->findBy(['type' => $type], ['id' => 'DESC']),
            // $request->query->getInt('page', 1), /*page number*/ 8 /*limit per page*/
            $number ?? 1, /*page number*/ 8 /*limit per page*/
        );

        return $this->render('pages/main.html.twig', compact('images')); 
    }

    /**
     * Page Main, Read Image, Paginate, Gender, Number
     *
     * @param integer $number
     * @param string $gender
     * @param Request $request
     * @param ImageRepository $image
     * @param PaginatorInterface $paginator
     * @return Response
     */ 
    #[Route('/gender/{gender}/page/{number}', name: 'loli_gender', methods: ['GET'])]
    public function genderPaginate(int $number, string $gender, Request $request, ImageRepository $image, PaginatorInterface $paginator): Response
    {
        $images = $paginator->paginate(
            $image->findBy(['gender' => $gender], ['id' => 'DESC']),
            // $request->query->getInt('page', 1), /*page number*/ 8 /*limit per page*/
            $number ?? 1, /*page number*/ 8 /*limit per page*/
        );

        return $this->render('pages/main.html.twig', compact('images')); 
    }
}