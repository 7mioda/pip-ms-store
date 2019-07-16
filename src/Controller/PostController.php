<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\CategoryType;
use App\Form\PostType;
use App\Repository\PostRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;


class PostController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/posts", name="post_index")
     * @param PostRepository $postRepository
     * @return View
     * @Rest\View()
     */
    public function index(PostRepository $postRepository): View
    {
        $posts = $postRepository->findAll();
        if (!$posts) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($posts, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Post("/posts/new", name="post_new")
     * @param Request $request
     * @param Uploader $uploader
     * @return View|FormInterface
     * @Rest\View()
     */
    public function new(Request $request, Uploader $uploader)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->submit($request->request->all());
        if(!$form->isValid()){
            return $form;
        }
        ### test file Uploads
        $image = $uploader->uploadImage($request->files->get('image'), []);
        $post->setImage($image);
        ### test file Uploads
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();
        return View::create($post, Response::HTTP_CREATED,[]);
    }


    /**
     * @Rest\Get("/posts/{id}", name="post_show")
     * @param Post $post
     * @return View
     */
    public function show(Post $post): View
    {
        if (!$post) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($post, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Post("posts/edit/{id}", name="post_edit")
     * @param Request $request
     * @param Post $post
     * @return View|FormInterface
     */
    public function edit(Request $request, Post $post)
    {
        if (!$post) {
            throw $this->createNotFoundException("Data not found.");
        }
        $form = $this->createForm(CategoryType::class, $post);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();
        return View::create($post, Response::HTTP_OK, []);
    }


    /**
     * @Rest\Delete("/posts/delete/{id}", name="post_delete")
     * @param Post $post
     * @return View
     */
    public function delete(Post $post): View
    {
        if (!$post) {
            throw $this->createNotFoundException("Data not found.");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($post);
        $entityManager->flush();
        return View::create(null,Response::HTTP_OK);
    }
}
