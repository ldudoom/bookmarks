<?php

namespace App\Controller;

use App\Repository\BookmarkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(BookmarkRepository $bookmarkRepository): Response
    {
        return $this->render('index/index.html.twig', [
            'bookmarks' => $bookmarkRepository->findAll(),
        ]);
    }
}
