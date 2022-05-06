<?php

namespace App\Controller;

use App\Entity\Bookmark;
use App\Entity\Category;
use App\Repository\BookmarkRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    protected CategoryRepository $_categoryRepository;
    protected BookmarkRepository $_bookmarkRepository;

    public function __construct(CategoryRepository $categoryRepository, BookmarkRepository $bookmarkRepository)
    {
        $this->_categoryRepository = $categoryRepository;
        $this->_bookmarkRepository = $bookmarkRepository;
    }

    #[Route('/favorites', name: 'app_favorites')]
    public function favorites()
    {
        return $this->render('index/index.html.twig', [
            'bookmarks' => $this->_bookmarkRepository->findBy(['favorite' => true]),
        ]);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    #[Route('/add-remove-favorite/{bookmark}', name: 'app_edit_favorite')]
    public function addEditFavorite(Bookmark $bookmark, Request $request)
    {
        $bookmark->setFavorite( ! $bookmark->getFavorite());
        $this->_bookmarkRepository->add($bookmark);
        if($request->isXmlHttpRequest()){
            return $this->json([
                'status' => true,
                'message' => 'Bookmark "'.$bookmark->getName().'" updated successfully',
                'newClass' => $bookmark->getFavorite() ? 'btn-success' : 'btn-outline-success',
            ], Response::HTTP_OK);
        }
        $this->addFlash('success', 'Bookmark "'.$bookmark->getName().'" updated successfully');
        return  $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{categoryName}', name: 'app_index', defaults: ['categoryName' => ''])]
    public function index(string $categoryName): Response
    {
        if($categoryName){
            $category = $this->_categoryRepository->findOneBy(['name' => $categoryName]);
            if($category instanceof Category){
                $bookmarks = $this->_bookmarkRepository->findBy(['category' => $category->getId()]);
            }else{
                $bookmarks = $this->_bookmarkRepository->findAll();
            }
        }else{
            $bookmarks = $this->_bookmarkRepository->findAll();
        }
        return $this->render('index/index.html.twig', [
            'bookmarks' => $bookmarks,
        ]);
    }
}
