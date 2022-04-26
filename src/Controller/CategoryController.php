<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\CategoryRepository;

class CategoryController extends AbstractController
{
    protected CategoryRepository $_category;

    public function __construct(CategoryRepository $category)
    {
        $this->_category = $category;
    }

    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $this->_category->findAll(),
        ]);
    }
}
