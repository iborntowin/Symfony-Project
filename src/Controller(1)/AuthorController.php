<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    #[Route('/author/{id}', name: 'authorDetails')]
    public function authorDetails(int $id): Response
    {
        $author = $this->authorRepository->find($id);

        if (!$author) {
            return new Response('Auteur non trouvé', 404);
        }

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/listauthors', name: 'list_authors')]
    public function listAuthors(): Response
    {
        $authors = $this->authorRepository->findAll();
        return $this->render('author/list.html.twig', [
            'authors' => $authors, // Pass as 'authors'
        ]);
    }

    #[Route('/findauthor/{id}', name: 'findByid')]
    public function findByid(int $id): Response
    {
        $author = $this->authorRepository->find($id);

        if (!$author) {
            return new Response('Auteur non trouvé', 404);
        }

        return $this->render('author/authorDetails.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/goToAuthors', name: 'goToAuthors')]
    public function goToAuthors(): Response
    {
        return $this->redirectToRoute('list_authors');
    }
}
