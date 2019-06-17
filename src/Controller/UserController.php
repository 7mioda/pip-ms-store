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
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/users", name="user_index")
     * @param UserRepository $userRepository
     * @return View
     */
    public function index(UserRepository $userRepository)
    {
        return View::create(['users' => $userRepository->findAll()]);
    }

    /**
     * @Rest\Post("/new", name="user_new")
     * @param Request $request
     * @return View
     */
    public function new(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());
        if(!$form->isValid()){
            View::create(['test' => $form]);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        return View::create(['status' => 'OK', 'user' => $user]);
    }

    /**
     * @Rest\Get("/users/{id}", name="user_show")
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return View::create(['user' => $user]);
    }
//
//    /**
//     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
//     */
//    public function edit(Request $request, User $user): Response
//    {
//        $form = $this->createForm(UserType::class, $user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('user_index', [
//                'id' => $user->getId(),
//            ]);
//        }
//
//        return $this->render('user/edit.html.twig', [
//            'user' => $user,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{id}", name="user_delete", methods={"DELETE"})
//     */
//    public function delete(Request $request, User $user): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($user);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('user_index');
//    }
}
