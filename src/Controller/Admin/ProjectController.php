<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\services\HandleUploadImageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/projects", name="admin_project_index")
     */
    public function index(Request $request, ProjectRepository $projectRepository): Response
    {
        return $this->render('Admin/project/index.html.twig', [
            'controller_name' => 'ProjectController',
            'projects' => $projectRepository->findAll()
        ]);
    }

    /**
     * @Route("/project/create", name="admin_project_create")
     */
    public function create(Request $request, EntityManagerInterface $manager, HandleUploadImageInterface $uploader, string $uploadDir)
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project, [
            'validation_groups' => ['Default', 'Create']
        ])->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            try
            {
                $file = $form->get('file')->getData();
                $startAt = $form->get('startAt')->getData();
                $finishAt = $form->get('finishAt')->getData();
                $project->setImage($uploader->uploadImage($file, $uploadDir));
                $project->setStartAt($startAt);
                $project->setFinishAt($finishAt);
                $manager->persist($project);
                $manager->flush();
                return $this->redirectToRoute('admin_project_index');
            }
            catch (\Exception $exception)
            {
                $this->addFlash('save_error', $exception->getMessage());
            }
        }
        return $this->render('Admin/project/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/project/edit/{id}", name="admin_project_edit")
     */
    public function edit(Request $request, Project $project, HandleUploadImageInterface $uploader, string $uploadDir, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ProjectType::class, $project)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $file = $form->get('file')->getData();
            $startAt = $form->get('startAt')->getData();
            $finishAt = $form->get('finishAt')->getData();
            $project->setStartAt($startAt);
            $project->setFinishAt($finishAt);
            if ($file !== null)
            {
                $oldimage = $project->getImage();
                $project->setImage($uploader->uploadImage($file, $uploadDir));
                $uploader->removeUploadFile($uploadDir . '/' . $oldimage);
            }
            $manager->flush();
            return $this->redirectToRoute('admin_project_index');
        }
        $form->get('startAt')->setData($project->getStartAt());
        $form->get('finishAt')->setData($project->getFinishAt());
        return $this->render('Admin/project/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/project/delete/{id}", name="admin_project_delete")
     */
    public function remove(Request $request, Project $project, HandleUploadImageInterface $uploader, string $uploadDir, EntityManagerInterface $manager)
    {
        $image = $project->getImage();
        $manager->remove($project);
        $manager->flush();
        $uploader->removeUploadFile($uploadDir . '/' . $image);
        return $this->redirectToRoute('admin_project_index');
    }
}
