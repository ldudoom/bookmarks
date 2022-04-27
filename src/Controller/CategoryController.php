<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\CategoryRepository;

#[Route('/category')]
class CategoryController extends AbstractController
{
    protected CategoryRepository $_category;
    protected EntityManagerInterface $_em;

    public function __construct(CategoryRepository $category, EntityManagerInterface $em)
    {
        $this->_category = $category;
        $this->_em = $em;
    }

    #[Route('/list', name: 'app_category_list', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $this->_category->findAll(),
        ]);
    }

    #[Route('/create', name: 'app_category_create', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('category/create.html.twig');
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    #[Route('/store', name: 'app_category_store', methods: ['POST'])]
    public function store(Request $request): Response
    {
        if( $this->isCsrfTokenValid('category', $request->request->get('_token')) ){
            $category = new Category();
            $category->setName($request->request->get('name', ''));
            $this->_category->add($category);
        }
        return $this->redirectToRoute('app_category_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/edit/{category}', name: 'app_category_edit', methods: ['GET'])]
    public function edit(Category $category): Response
    {
        return $this->render('category/edit.html.twig', [
            'category' => $category
        ]);
    }

    #[Route('/update/{category}', name: 'app_category_update', methods: ['PUT', 'PATCH'])]
    public function update(Request $request, Category $category): Response
    {
        if( $this->isCsrfTokenValid('category', $request->request->get('_token')) ){
            $category->setName($request->request->get('name'));
        }
        return $this->redirectToRoute('app_category_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/show/{category}', name: 'app_category_show', methods: ['GET'])]
    public function show(CategoryRepository $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }

    #[Route('/destroy/{category}', name: 'app_category_destroy', methods: ['DELETE'])]
    public function destroy(CategoryRepository $category): Response
    {
        return $this->render('category/show.html.twig');
    }


}
