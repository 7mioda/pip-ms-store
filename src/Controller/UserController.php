<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;


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
        if (!$users) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($users, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Post("/users/new", name="user_new")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param JWTTokenManagerInterface $JWTManager
     * @param Publisher $publisher
     * @return View|FormInterface
     * @Rest\View()
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $encoder, JWTTokenManagerInterface $JWTManager, Publisher $publisher)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        $encoded = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($user->getPassword());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        $publisher->publish('http://example.com/users', ['status' => 'user created']);

        return View::create(null, Response::HTTP_CREATED, ['token' => $JWTManager->create($user)]);
    }

    /**
     * @Rest\Post("/users/login", name="login")
     * @param Request $request
     * @param JWTTokenManagerInterface $JWTManager
     * @return View|FormInterface
     * @Rest\View()
     */
    public function login(Request $request, JWTTokenManagerInterface $JWTManager)
    {
        return View::create(null, Response::HTTP_CREATED, ['token' => 'ddddd']);
    }

    /**
     * @Rest\Get("/users/{id}", name="user_show")
     * @param User $user
     * @return View
     * @Rest\View()
     */
    public function show(User $user): View
    {
        if (!$user) {
            throw $this->createNotFoundException("Data not found.");
        }
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
        if (!$user) {
            throw $this->createNotFoundException("Data not found.");
        }
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
        if (!$user) {
            throw $this->createNotFoundException('Data not found.');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        return View::create(null,Response::HTTP_OK);
    }
}
