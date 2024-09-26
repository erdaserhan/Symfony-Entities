<?php

namespace App\Controller;

# appel du gestionnaire de section
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(SectionRepository $sections): Response
    {
        return $this->render('main/index.html.twig', [
            'title' => 'Homepage',
            'homepage_text' => "Nous sommes le ".date('d/m/Y \à H:i'),
            # on met dans une variable pour twig toutes les sections récuperées
            'sections' => $sections->findAll()
        ]);
    }

    #[Route('/about', name: 'about_me')]
    public function aboutMe(SectionRepository $sections): Response
    {
        return $this->render('main/about.html.twig', [
            'title' => 'About me Baby',
            'homepage_text' => "Et C'est moi !",
            'sections' => $sections->findAll()
        ]);
    }
}
