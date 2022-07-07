<?php

namespace App\Controller\Front;

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
        return $this->render('Front/home/index.html.twig', [
            'user' => $user,
        ]);
    }
}
