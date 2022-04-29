<?php

namespace App\Controller;

use App\Entity\Category;
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
    protected EntityManagerInterface $_entityManager;

    public function __construct(CategoryRepository $category, EntityManagerInterface $entityManager)
    {
        $this->_category = $category;
        $this->_entityManager = $entityManager;
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
        if(  ! $this->isCsrfTokenValid('category', $request->request->get('_token')) ){
            $this->addFlash('danger', 'CSRF token is invalid.');
            return $this->redirectToRoute('app_category_create', [], Response::HTTP_SEE_OTHER);
        }
        $category = new Category();
        $category->setName($request->request->get('name', ''));
        $category->setColor($request->request->get('color', ''));
        $this->_category->persist($category);
        $this->addFlash('success', 'Category created successfully');
        return $this->redirectToRoute('app_category_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/edit/{category}', name: 'app_category_edit', methods: ['GET'])]
    public function edit(Category $category): Response
    {
        return $this->render('category/edit.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    #[Route('/update/{category}', name: 'app_category_update', methods: ['PUT', 'PATCH', 'POST'])]
    public function update(Request $request, Category $category): Response
    {
        if(  ! $this->isCsrfTokenValid('category', $request->request->get('_token')) ){
            $this->addFlash('danger', 'CSRF token is invalid.');
            return $this->redirectToRoute('app_category_edit', [], Response::HTTP_SEE_OTHER);
        }
        $category->setName($request->request->get('name', ''));
        $category->setColor($request->request->get('color', ''));
        $this->_category->persist($category);
        $this->addFlash('success', 'Category updated successfully');
        return $this->redirectToRoute('app_category_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/show/{category}', name: 'app_category_show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    #[Route('/destroy/{category}', name: 'app_category_destroy', methods: ['DELETE', 'POST'])]
    public function destroy(Category $category): Response
    {
        $this->_category->remove($category);
        $this->addFlash('success', 'Category "'.$category->getName().'" deleted successfully');
        return $this->redirectToRoute('app_category_list', [], Response::HTTP_SEE_OTHER);
    }


}
