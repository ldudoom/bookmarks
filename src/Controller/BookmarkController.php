<?php

namespace App\Controller;

use App\Entity\Bookmark;
use App\Form\BookmarkType;
use App\Repository\BookmarkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookmarkController extends AbstractController
{
    public function index(BookmarkRepository $bookmarkRepository): Response
    {
        return $this->render('bookmark/index.html.twig', [
            'bookmarks' => $bookmarkRepository->findAll(),
        ]);
    }

    public function new(Request $request, BookmarkRepository $bookmarkRepository): Response
    {
        $bookmark = new Bookmark();
        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookmarkRepository->add($bookmark);
            $this->addFlash('success', 'Bookmark "'.$bookmark->getName().'" created successfully');
            return $this->redirectToRoute('app_bookmark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookmark/new.html.twig', [
            'bookmark' => $bookmark,
            'form' => $form,
        ]);
    }

    public function show(Bookmark $bookmark): Response
    {
        return $this->render('bookmark/show.html.twig', [
            'bookmark' => $bookmark,
        ]);
    }

    public function edit(Request $request, Bookmark $bookmark, BookmarkRepository $bookmarkRepository): Response
    {
        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookmarkRepository->add($bookmark);
            $this->addFlash('success', 'Bookmark "'.$bookmark->getName().'" updated successfully');
            return $this->redirectToRoute('app_bookmark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookmark/edit.html.twig', [
            'bookmark' => $bookmark,
            'form' => $form,
        ]);
    }

    public function delete(Request $request, Bookmark $bookmark, BookmarkRepository $bookmarkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookmark->getId(), $request->request->get('_token'))) {
            $bookmarkRepository->remove($bookmark);
        }
        $this->addFlash('success', 'Bookmark "'.$bookmark->getName().'" deleted successfully');
        return $this->redirectToRoute('app_bookmark_index', [], Response::HTTP_SEE_OTHER);
    }
}
