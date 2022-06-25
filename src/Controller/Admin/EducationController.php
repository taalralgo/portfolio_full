<?php

namespace App\Controller\Admin;

use App\Entity\Education;
use App\Form\EducationType;
use App\Repository\EducationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class EducationController extends AbstractController
{
    /**
     * @Route("/educations", name="admin_education_index")
     */
    public function index(EducationRepository $educationRepository): Response
    {
        return $this->render('Admin/education/index.html.twig', [
            'educations' => $educationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/education/create", name="admin_education_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $education = new Education();
        $form = $this->createForm(EducationType::class, $education)->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($education);
            $manager->flush();
            return $this->redirectToRoute("admin_education_index");
        }
        return $this->render("Admin/education/create.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/education/edit/{id}", name="admin_education_edit")
     */
    public function edit(Request $request, Education $education, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(EducationType::class, $education)->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->flush();
            return $this->redirectToRoute("admin_education_index");
        }
        return $this->render("Admin/education/edit.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/education/delete/{id}", name="admin_education_delete")
     */
    public function remove(Education $education, EntityManagerInterface $manager): Response
    {
        $manager->remove($education);
        $manager->flush();
        return $this->redirectToRoute("admin_education_index");
    }
}
