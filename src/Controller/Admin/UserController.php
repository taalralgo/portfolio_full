<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\services\HandleUploadImageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users", name="admin_user_index")
     */
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('Admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="admin_user_edit")
     */
    public function edit(
        Request                $request, User $user, UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $manager, HandleUploadImageInterface $uploader, string $uploadDir): Response
    {
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var User $editUser */
            $editUser = $form->getData();
            $new_password = $form->get('new_password')->getData();
            $confirm_password = $form->get('confirm_password')->getData();
            $user->setName($editUser->getName());
            $user->setEmail($editUser->getEmail());
            $user->setAbout($editUser->getAbout());
            if (!empty($new_password) && $new_password === $confirm_password)
            {
                $user->setPassword($passwordHasher->hashPassword($editUser->getNewPassword()));
            }
            $file = $form->get('file')->getData();
            if ($file !== null)
            {
                $oldImage = $user->getImage();
                $user->setImage($uploader->uploadImage($file, $uploadDir));
                if ($oldImage)
                {
                    $uploader->removeUploadFile($uploadDir . '/' . $oldImage);
                }
            }
            $manager->flush();
            return $this->redirectToRoute('admin_user_index');
        }
        return $this->render('Admin/user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
