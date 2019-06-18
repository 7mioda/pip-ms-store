<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/users", name="user_index")
     * @param UserRepository $userRepository
     * @return View
     *@Rest\View()
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        var_dump($users);
        return View::create($users, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Post("/users/new", name="user_new")
     * @param Request $request
     * @return View|FormInterface
     * @Rest\View()
     */
    public function new(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return View::create($user, Response::HTTP_CREATED, []);
    }

    /**
     * @Rest\Get("/users/{id}", name="user_show")
     * @param User $user
     * @return View
     * @Rest\View()
     */
    public function show(User $user): View
    {
        return View::create($user, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Post("/users/edit/{id}", name="user_edit")
     * @param Request $request
     * @param User $user
     * @return View|FormInterface
     */
    public function edit(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return View::create($user,Response::HTTP_OK, []);
    }

    /**
     * @Rest\Delete("/users/delete/{id}", name="user_delete")
     * @param User $user
     * @return View
     * @Rest\View()
     */
    public function delete(User $user): View
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        return View::create(null,Response::HTTP_OK);
    }
}
