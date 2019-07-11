<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategoryController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/categories", name="category_index")
     * @param CategoryRepository $categoryRepository
     * @return View
     * @Rest\View()
     */
    public function index(CategoryRepository $categoryRepository): View
    {
        $categories = $categoryRepository->findAll();
        if (!$categories) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($categories, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Post("/categories/new", name="category_new")
     * @param Request $request
     * @param Uploader $uploader
     * @return View|FormInterface
     * @Rest\View()
     */
    public function new(Request $request, Uploader $uploader): View
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->submit($request->request->all());
        if(!$form->isValid()){
            return $form;
        }
        ### test file Uploads
        $image = $uploader->uploadImage($request->files->get('description'), []);
        $category->setDescription($image);
        ### test file Uploads
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->flush();
        return View::create($category, Response::HTTP_CREATED,[]);
    }


    /**
     * @Rest\Get("/categories/{id}", name="category_show")
     * @param Category $category
     * @return View
     */
    public function show(Category $category): View
    {
        if (!$category) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($category, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Post("categories/edit/{id}", name="category_edit")
     * @param Request $request
     * @param Category $category
     * @return View|FormInterface
     */
    public function edit(Request $request, Category $category)
    {
        if (!$category) {
            throw $this->createNotFoundException("Data not found.");
        }
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->flush();
        return View::create($category, Response::HTTP_OK, []);
    }

    /**
     * @Rest\Delete("/categories/delete/{id}", name="category_delete")
     * @param Category $category
     * @return View
     */
    public function delete(Category $category): View
    {
        if (!$category) {
            throw $this->createNotFoundException("Data not found.");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        return View::create(null,Response::HTTP_OK);
    }
}
