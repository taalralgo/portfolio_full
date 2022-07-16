<?php

namespace App\Controller\Front;

use App\Entity\Project;
use App\Entity\Techno;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    const USER_ID = 1;
    /**
     * @Route("/", name="front_home")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $user = $manager->getRepository(User::class)->find(self::USER_ID);
        $technos = $manager->getRepository(Techno::class)->findAll();
        $projects = $manager->getRepository(Project::class)->findAll();
        return $this->render('Front/home/index.html.twig', [
            'user' => $user,
            'technos' => $technos,
            'projects' => $projects,
        ]);
    }
}
