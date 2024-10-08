<?php

namespace App\Controller;

# appel du gestionnaire de section
use App\Repository\SectionRepository;
# Appel de l'EntityManagerInterface
use Doctrine\ORM\EntityManagerInterface;
#Appel de l'Entity Post
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(SectionRepository $sections, EntityManagerInterface $em): Response
    {
        $posts = $em->getRepository(Post::class)->findBy(['postIsPublished'=>true], ['postDatePublished'=>'DESC']);
        // dump and die, débug mais arrête le script
        // dd($posts);
        return $this->render('main/index.html.twig', [
            'title' => 'Homepage',
            'homepage_text' => "Nous sommes le ".date('d/m/Y \à H:i'),
            # on met dans une variable pour twig toutes les sections récuperées
            'sections' => $sections->findAll(),
            # Liste des postes
            'posts' => $posts,
        ]);
    }

    //Création de l'url pour le détail d'une section
    #[Route(
        path: '/section/{id}',
        name: 'section',
        requirements: ['id' => '\d+'],
        defaults: ['id'=>1])]

    public function section(SectionRepository $sections, int $id): Response
    {
        $section = $sections->find($id);
        return $this->render('main/section.html.twig', [
            'title' => 'Section => '.$section->getSectionTitle(),
            'homepage_text' => $section->getSectionDescription(),
            'section' => $section,
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
