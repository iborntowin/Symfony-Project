<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Author;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/livre')]
final class LivreController extends AbstractController
{
    private AuthorRepository $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    #[Route(name: 'app_livre_index', methods: ['GET'])]
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_livre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $file */
            $file = $form->get('picture')->getData();

            if ($file) {
                $fileName = uniqid() . '.' . $file->guessExtension();
                $file->move($this->getParameter('pictures_directory'), $fileName);
                $livre->setPicture($fileName);
            }

            // Associate the Livre with an Author (you can adjust this logic)
            $author = $this->authorRepository->find(1); // Change this to your specific logic
            if ($author) {
                $livre->setAuthor($author);
            }

            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('app_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_livre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $file */
            $file = $form->get('picture')->getData();

            if ($file) {
                $fileName = uniqid() . '.' . $file->guessExtension();
                $file->move($this->getParameter('pictures_directory'), $fileName);
                $livre->setPicture($fileName);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_livre_delete', methods: ['POST'])]
    public function delete(string $ref, EntityManagerInterface $entityManager, LivreRepository $livreRepository): Response
    {
        $livre = $livreRepository->find($ref);
        
        if (!$livre) {
            throw $this->createNotFoundException('No book found for reference ' . $ref);
        }

        $entityManager->remove($livre);
        $entityManager->flush();

        return $this->redirectToRoute('app_livre_index');
    }
}
