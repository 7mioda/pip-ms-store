<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Like;
use App\Form\CommentType;
use App\Form\LikeType;
use App\Repository\CommentRepository;
use App\Repository\LikeRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;


class LikeController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/likes", name="like_index")
     * @param LikeRepository $likeRepository
     * @return View
     * @Rest\View(serializerGroups={"likeService"})
     */
    public function index(LikeRepository $likeRepository): View
    {
        $likes = $likeRepository->findAll();
        if (!$likes) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($likes, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Post("/likes/new", name="like_new")
     * @param Request $request
     * @return View|FormInterface
     * @Rest\View(serializerGroups={"service"})
     */
    public function new(Request $request)
    {
        $like = new Like();
        $form = $this->createForm(LikeType::class, $like);
        $form->submit($request->request->all());

        if(!$form->isValid()){
            return $form;
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($like);
        $entityManager->flush();
        return View::create($like, Response::HTTP_CREATED,[]);
    }


    /**
     * @Rest\Get("/likes/{id}", name="like_show")
     * @param Like $like
     * @return View
     */

    public function show(Like $like): View
    {
        if (!$like) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($like, Response::HTTP_OK, []);
    }


    /**
     * @Rest\Post("likes/edit/{id}", name="like_edit")
     * @param Request $request
     * @param Like $like
     * @return View|FormInterface
     */
    public function edit(Request $request, Like $like): View
    {
        if (!$like) {
            throw $this->createNotFoundException("Data not found.");
        }
        $form = $this->createForm(LikeType::class, $like);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($like);
        $entityManager->flush();
        return View::create($like, Response::HTTP_OK, []);
    }


    /**
     * @Rest\Delete("/likes/delete/{id}", name="like_delete")
     * @param Like $like
     * @return View
     */
    public function delete(Like $like): View
    {
        if (!$like) {
            throw $this->createNotFoundException("Data not found.");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($like);
        $entityManager->flush();
        return View::create(null,Response::HTTP_OK);
    }
}
