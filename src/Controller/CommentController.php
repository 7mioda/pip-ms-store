<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;


class CommentController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/comments", name="comment_index")
     * @param CommentRepository $commentRepository
     * @return View
     * @Rest\View(serializerGroups={"commentService"})
     */
    public function index(CommentRepository $commentRepository): View
    {
        $comments = $commentRepository->findAll();
        if (!$comments) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($comments, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Post("/comments/new", name="comment_new")
     * @param Request $request
     * @return View|FormInterface
     * @Rest\View(serializerGroups={"service"})
     */
    public function new(Request $request)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->submit($request->request->all());

        if(!$form->isValid()){
            return $form;
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();
        return View::create($comment, Response::HTTP_CREATED,[]);
    }


    /**
     * @Rest\Get("/comments/{id}", name="comment_show")
     * @param Comment $comment
     * @return View
     */

    public function show(Comment $comment): View
    {
        if (!$comment) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($comment, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Post("comments/edit/{id}", name="comment_edit")
     * @param Request $request
     * @param Comment $comment
     * @return View|FormInterface
     */
    public function edit(Request $request, Comment $comment): View
    {
        if (!$comment) {
            throw $this->createNotFoundException("Data not found.");
        }
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();
        return View::create($comment, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Delete("/comments/delete/{id}", name="comment_delete")
     * @param Comment $comment
     * @return View
     */
    public function delete(Comment $comment): View
    {
        if (!$comment) {
            throw $this->createNotFoundException("Data not found.");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($comment);
        $entityManager->flush();
        return View::create(null,Response::HTTP_OK);
    }
}
