<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Twig\Error\Error;


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
     * @Rest\Get("/sellers", name="sellers_index")
     * @param UserRepository $userRepository
     * @return View
     *@Rest\View()
     */
    public function sellers(UserRepository $userRepository)
    {
        $sellers = $userRepository->findByRole(User::$SELLER);
        if (!$sellers) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($sellers, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Get("/users/reset-password-mail/{id}", name="user_reset_password_mail")
     * @param User $user
     * @param Mailer $mailer
     * @return View
     * @Rest\View()
     */
    public function resetPasswordMail(User $user, Mailer $mailer)
    {
        $token = rand (1000000,9999999);
        try {
            $mailer->sendResettingEmailMessage(
                [
                    'username' => $user->getFirstName() . ' ' . $user->getLastName(),
                    'confirmationLink' => 'http://localhost:8000/api/users/reset-password/'.$user->getId().'?token='.$token,
                    'email' => $user->getEmail()
                ]
            );
        } catch (Error $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return View::create([], Response::HTTP_OK, []);
    }

    /**
     * @Rest\Get("/users/reset-password/{id}", name="user_reset_password")
     * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return View
     * @Rest\View()
     */
    public function resetPassword(Request $request, User $user, EntityManagerInterface $entityManager)
    {
        $token = $request->query->get('token');
        if ($token){
           $user->setPassword($token);
        }
        $entityManager->persist($user);
        $entityManager->flush();
        return View::create([], Response::HTTP_OK, []);
    }

    /**
     * @Rest\Post("/users/new", name="user_new")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $entityManager
     * @param Publisher $publisher
     * @return View|FormInterface
     * @Rest\View(serializerGroups={"auth"})
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $encoder,  EntityManagerInterface $entityManager, Publisher $publisher)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        $encoded = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);
        $entityManager->persist($user);
        $entityManager->flush();
        $publisher->publish('http://example.com/users', ['status' => 'user created']);

        return View::create($user, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Post("/users/login", name="login")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $encoder
     * @param Mailer $mailer
     * @param EntityManagerInterface $entityManager
     * @return View|FormInterface
     * @Rest\View(serializerGroups={"auth"})
     */
    public function login(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $encoder, Mailer $mailer, EntityManagerInterface $entityManager)
    {
        try {
        $user = $userRepository->findOneBy(['email' => $request->get('email')]);
            if($user && $encoder->isPasswordValid($user, $request->get('password'))){
            if($user->getStatus() === User::$FIRST_CONNECTED){
                $user->setStatus(User::$ACTIVE);
                $entityManager->persist($user);
                $entityManager->flush();
                $mailer->sendFirstLoginEmailMessage($user);
            }
            return View::create($user, Response::HTTP_CREATED);
        }
        return View::create(null, Response::HTTP_UNAUTHORIZED);
        } catch (Error $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
