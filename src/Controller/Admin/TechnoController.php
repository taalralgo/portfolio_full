<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Techno;
use App\Form\TechnoType;
use App\Helper\Helper;
use App\Repository\TechnoRepository;
use App\services\HandleUploadImageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class TechnoController extends AbstractController
{
    /**
     * @Route("/technos", name="admin_techno_index")
     */
    public function index(TechnoRepository $repository): Response
    {
        return $this->render('Admin/techno/index.html.twig', [
            'technos' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/techno/create", name="admin_techno_create")
     */
    public function create(Request $request, EntityManagerInterface $manager, HandleUploadImageInterface $uploader, string $uploadDir): Response
    {
        $techno = new Techno();
        $form = $this->createForm(TechnoType::class, $techno, [
            "validation_groups" => ["Default", "Create"]
        ])->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            try
            {
                /** @var UploadedFile $image */
                $uploadFile = $form->get('file')->getData();
                $techno->setImage($uploader->uploadImage($uploadFile, $uploadDir));
                $manager->persist($techno);
                $manager->flush();
                return $this->redirectToRoute('admin_techno_index');
            }
            catch (\Exception $exception)
            {
                $this->addFlash('save_error', $exception->getMessage());
            }

        }
        return $this->render('Admin/techno/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/techno/edit/{id}", name="admin_techno_edit")
     */
    public function edit(Request $request, Techno $techno, EntityManagerInterface $manager, HandleUploadImageInterface $uploader, string $uploadDir)
    {
        $form = $this->createForm(TechnoType::class, $techno)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $file = $form->get('file')->getData();
            if ($file !== null)
            {
                $oldImage = $techno->getImage();
                $techno->setImage($uploader->uploadImage($file, $uploadDir));
                $uploader->removeUploadFile($uploadDir . '/' . $oldImage);
            }
            $manager->flush();
            return $this->redirectToRoute('admin_techno_index');
        }
        return $this->render('Admin/techno/edit.html.twig', [
            'techno' => $techno,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/techno/delete/{id}", name="admin_techno_delete")
     */
    public function remove(Request $request, Techno $techno, EntityManagerInterface $manager, HandleUploadImageInterface $uploader, string $uploadDir): Response
    {
        $image = $techno->getImage();
        $manager->remove($techno);
        $manager->flush();
        $uploader->removeUploadFile($uploadDir . '/' . $image);
        return $this->redirectToRoute('admin_techno_index');
    }
}
