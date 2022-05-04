<?php

namespace App\Controller;

use App\Entity\Bookmark;
use App\Form\BookmarkType;
use App\Repository\BookmarkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bookmark')]
class BookmarkController extends AbstractController
{
    #[Route('/', name: 'app_bookmark_index', methods: ['GET'])]
    public function index(BookmarkRepository $bookmarkRepository): Response
    {
        return $this->render('bookmark/index.html.twig', [
            'bookmarks' => $bookmarkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bookmark_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookmarkRepository $bookmarkRepository): Response
    {
        $bookmark = new Bookmark();
        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookmarkRepository->add($bookmark);
            return $this->redirectToRoute('app_bookmark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookmark/new.html.twig', [
            'bookmark' => $bookmark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bookmark_show', methods: ['GET'])]
    public function show(Bookmark $bookmark): Response
    {
        return $this->render('bookmark/show.html.twig', [
            'bookmark' => $bookmark,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bookmark_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bookmark $bookmark, BookmarkRepository $bookmarkRepository): Response
    {
        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookmarkRepository->add($bookmark);
            return $this->redirectToRoute('app_bookmark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookmark/edit.html.twig', [
            'bookmark' => $bookmark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bookmark_delete', methods: ['POST'])]
    public function delete(Request $request, Bookmark $bookmark, BookmarkRepository $bookmarkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookmark->getId(), $request->request->get('_token'))) {
            $bookmarkRepository->remove($bookmark);
        }

        return $this->redirectToRoute('app_bookmark_index', [], Response::HTTP_SEE_OTHER);
    }
}
