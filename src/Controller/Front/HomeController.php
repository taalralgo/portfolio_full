<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Entity\Education;
use App\Entity\Experience;
use App\Entity\Project;
use App\Entity\Techno;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $educations = $manager->getRepository(Education::class)->findAll();
        $experiences = $manager->getRepository(Experience::class)->findBy([], ['name_company' => 'ASC']);
        return $this->render('Front/home/index.html.twig', [
            'user' => $user,
            'technos' => $technos,
            'projects' => $projects,
            'educations' => $educations,
            'experiences' => $experiences,
        ]);
    }

    /**
     * @Route("/send-message", name="front_send_message")
     */
    public function sendMessage(Request $request): Response
    {
        if (!$request->isMethod('POST'))
        {
            $this->addFlash("contact_error", "La methode n'est pas bien definie.");
            return $this->redirectToRoute("front_home");
        }
        $this->addFlash("contact_success", "Votre message a été envoyé avec succès.");
        return $this->redirectToRoute("front_home");
    }

}
