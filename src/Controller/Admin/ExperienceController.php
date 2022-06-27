<?php

namespace App\Controller\Admin;

use App\Entity\Experience;
use App\Form\ExperienceType;
use App\Repository\ExperienceRepository;
use App\services\HandleUploadImageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class ExperienceController extends AbstractController
{
    /**
     * @Route("/experiences", name="admin_experience_index")
     */
    public function index(ExperienceRepository $experienceRepository): Response
    {
        return $this->render('Admin/experience/index.html.twig', [
            'experiences' => $experienceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/experience/create", name="admin_experience_create")
     */
    public function create(Request $request, EntityManagerInterface $manager, string $uploadDir, HandleUploadImageInterface $uploader): Response
    {
        $experience = new Experience();
        $form = $this->createForm(ExperienceType::class, $experience)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            try
            {
                $image = $form->get('image')->getData();
                if ($image !== null)
                {
                    $experience->setImageCompany($uploader->uploadImage($image, $uploadDir));
                }
                $manager->persist($experience);
                $manager->flush();
                return $this->redirectToRoute("admin_experience_index");
            }
            catch (\Exception $exception)
            {
                $this->addFlash("save_error", $exception->getMessage());
            }

        }
        return $this->render('Admin/experience/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/experience/edit/{id}", name="admin_experience_edit")
     */
    public function edit(Request $request, Experience $experience, EntityManagerInterface $manager, string $uploadDir, HandleUploadImageInterface $uploader): Response
    {
        $form = $this->createForm(ExperienceType::class, $experience)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            try
            {
                $image = $form->get('image')->getData();
                if ($image !== null)
                {
                    $oldImage = $experience->getImageCompany();
                    $experience->setImageCompany($uploader->uploadImage($image, $uploadDir));
                    if (!empty($oldImage))
                    {
                        $uploader->removeUploadFile($uploadDir . '/' . $oldImage);
                    }
                }
                $manager->flush();
                return $this->redirectToRoute("admin_experience_index");
            }
            catch (\Exception $exception)
            {
                $this->addFlash("save_error", $exception->getMessage());
            }
        }
        return $this->render('Admin/experience/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/experience/delete/{id}", name="admin_experience_delete")
     */
    public function remove(Request $request, Experience $experience, EntityManagerInterface $manager, string $uploadDir, HandleUploadImageInterface $uploader): Response
    {
        $oldImage = $experience->getImageCompany();
        if (!empty($oldImage))
        {
            $uploader->removeUploadFile($uploadDir . '/' . $oldImage);
        }
        $manager->remove($experience);
        $manager->flush();
        return $this->redirectToRoute("admin_experience_index");
    }
}
