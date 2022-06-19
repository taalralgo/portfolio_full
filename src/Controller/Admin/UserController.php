<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        return $this->render('Admin/user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
