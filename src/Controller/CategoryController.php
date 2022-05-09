<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\CategoryRepository;

class CategoryController extends AbstractController
{
    protected CategoryRepository $_category;
    protected EntityManagerInterface $_entityManager;

    public function __construct(CategoryRepository $category, EntityManagerInterface $entityManager)
    {
        $this->_category = $category;
        $this->_entityManager = $entityManager;
    }

    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $this->_category->findAll(),
        ]);
    }

    public function create(): Response
    {
        return $this->render('category/create.html.twig');
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
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
    public function destroy(Category $category): Response
    {
        $this->_category->remove($category);
        $this->addFlash('success', 'Category "'.$category->getName().'" deleted successfully');
        return $this->redirectToRoute('app_category_list', [], Response::HTTP_SEE_OTHER);
    }


}
