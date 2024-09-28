<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    #[Route('/service/{name}', name: 'show_service')]
    public function showService(string $name): Response
    {
        return $this->render('service/showService.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/welcome/{name}', name: 'welcome_service')] 
    public function welcome(string $name): Response
    {
        return $this->render('service/welcome.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/home', name: 'goToIndex')]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute('home/index.html.twig');  
    }

    #[Route('/service', name: 'goToService')]
    public function goToService(): Response
    {
        return $this->redirectToRoute('service/index.html.twig');  
    }

    #[Route('/welcome', name: 'goToWelcome')]
    public function goToWelcome(): Response
    {
        return $this->redirectToRoute('service/welcome.twig', [
            'name' => "",
        ]);  
        
    }

}