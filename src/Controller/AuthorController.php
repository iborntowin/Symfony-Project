<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Livre; // Add this for the Livre entity
use App\Form\AuthorType;
use App\Form\BookType; // Ensure you have BookType imported
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

class AuthorController extends AbstractController
{
    private  $authorRepository;
    private  $entityManager;

    public function __construct(AuthorRepository $authorRepository, EntityManagerInterface $entityManager)
    {
        $this->authorRepository = $authorRepository;
        $this->entityManager = $entityManager; // Inject EntityManager
    }

    #[Route('/author/{id}', name: 'authorDetails', requirements: ['id' => '\d+'])]
    public function authorDetails(int $id): Response
    {
        $author = $this->authorRepository->find($id);

        if (!$author) {
            throw $this->createNotFoundException('Author not found');
        }

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
        ]);
    }


    #[Route('/author/delete/{id}', name: 'author_delete', methods: ['POST'])]
public function deleteAuthor(Request $request, int $id): Response
{
    $token = $request->request->get('_csrf_token');
    if (!$this->isCsrfTokenValid('delete' . $id, $token)) {
        throw new InvalidCsrfTokenException();
    }

    $author = $this->authorRepository->find($id);
    if (!$author) {
        throw $this->createNotFoundException('Author not found');
    }

    foreach ($author->getLivres() as $livre) {
        $this->entityManager->remove($livre);
    }

    $this->entityManager->remove($author);
    $this->entityManager->flush();

    return $this->redirectToRoute('list_authors');
}

    
    #[Route('/listauthors', name: 'list_authors')]
    public function listAuthors(Request $request): Response
    {
        $email=$request->get('search');
        if($email){
        $authors=$this->authorRepository->search($email); 
        }
        else
        {
            $authors = $this->authorRepository->findAll();
        
        }
        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ]);
        
    }

    #[Route('/author/add', name: 'author_add', methods: ['GET', 'POST'])]
public function add(Request $request): Response
{
    $author = new Author();
    $form = $this->createForm(AuthorType::class, $author);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $file = $form->get('picture')->getData();

        if ($file) {
            $newFilename = uniqid() . '.' . $file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('authors_pictures_directory'), 
                    $newFilename
                );
                $author->setPicture($newFilename);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error uploading file: ' . $e->getMessage());
            }
        } else {
            $this->addFlash('error', 'No file was uploaded.');
        }

        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return $this->redirectToRoute('list_authors');
    }

    return $this->render('author/add.html.twig', [
        'form' => $form->createView(),
    ]);
}


#[Route('/goToAuthors', name: 'goToAuthors')]
public function goToAuthors(): Response
{
    return $this->redirectToRoute('list_authors');
}


    #[Route('/author/edit/{id}', name: 'author_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        $author = $this->authorRepository->find($id);
        if (!$author) {
            throw $this->createNotFoundException('Author not found');
        }

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('list_authors');
        }

        return $this->render('author/edit.html.twig', [
            'form' => $form->createView(),
            'author' => $author,
        ]);
    }

    #[Route('/author/{id}/livres', name: 'author_books', requirements: ['id' => '\d+'])]
    public function showBooksByAuthor(int $id): Response
    {
        $author = $this->authorRepository->find($id);

        if (!$author) {
            throw $this->createNotFoundException('Author not found');
        }

        $livres = $author->getLivres(); 

        return $this->render('author/showBooks.html.twig', [
            'author' => $author,
            'livres' => $livres,
        ]);
    }


    
}
