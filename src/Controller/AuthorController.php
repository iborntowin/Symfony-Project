<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private $authors;

    public function __construct() {
        $this->authors = [
            [
                'id' => 1,
                'picture' => '/images/Victor-Hugo.jpg',
                'username' => 'Victor Hugo',
                'email' => 'victor.hugo@gmail.com',
                'nb_books' => 100
            ],
            [
                'id' => 2,
                'picture' => '/images/william-shakespeare.jpg',
                'username' => 'William Shakespeare',
                'email' => 'william.shakespeare@gmail.com',
                'nb_books' => 200
            ],
            [
                'id' => 3,
                'picture' => '/images/Taha_Hussein.jpg',
                'username' => 'Taha Hussein',
                'email' => 'taha.hussein@gmail.com',
                'nb_books' => 300
            ]
        ];
    }

    #[Route('/author/{id}', name: 'authorDetails ')]
    public function authorDetails (int $id): Response
    {
        $author = null;
        foreach ($this->authors as $a) {
            if ($a['id'] === $id) {
                $author = $a;
                break;
            }
        }

        if (!$author) {
            return new Response('Auteur non trouvé', 404);
        }

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/listsauthors', name: 'list_authors')]
public function listAuthors(): Response
{
    return $this->render('author/list.html.twig', [
        'authors' => $this->authors,
    ]);
}


#[Route('/listsauthors', name: 'goToAuthors')]
    public function goToAuthors(): Response
    {
        return $this->redirectToRoute('author/list.html.twig');  
    }
}
