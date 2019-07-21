<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class ProductController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("/products", name="product_index")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @return View
     * @Rest\View(serializerGroups={"service"})
     */
    public function index(Request $request, ProductRepository $productRepository)
    {
        $offset = $request->query->get('offset');
        $limit = $request->query->get('limit');
        if($offset && $limit){
            $products = $productRepository->getPagination($offset, $limit);
        } else {
            $products = $productRepository->findAll();
        }

        if (!$products) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($products, Response::HTTP_OK, []);

    }


    /**
     * @Rest\Post("/products/new", name="product_new")
     * @param Request $request
     * @param Uploader $uploader
     * @return View|FormInterface
     * @Rest\View("service")
     */
    public function new(Request $request, Uploader $uploader)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->submit($request->request->all());
        if(!$form->isValid()){
            return $form;
        }
            $file = $request->files->get('image');
            if($file){
                $image = $uploader->uploadImage($file, []);
                $product->setImage($image);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
        return View::create($product, Response::HTTP_CREATED,[]);
    }


    /**
     * @Rest\Get("/products/{id}", name="product_show")
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        if (!$product) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($product, Response::HTTP_OK, []);

    }


    /**
     * @Rest\Post("products/edit/{id}", name="product_edit")
     * @param Request $request
     * @param Product $product
     * @return View|FormInterface
     */
    public function edit(Request $request, Product $product)
    {
        if (!$product) {
            throw $this->createNotFoundException("Data not found.");
        }
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
         }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();
        return View::create($product, Response::HTTP_OK, []);

    }


    /**
     * @Rest\Delete("/products/delete/{id}", name="product_delete")
     * @param Request $request
     * @param Product $product
     * @return View
     */
    public function delete(Request $request, Product $product): View
    {
        if (!$product) {
            throw $this->createNotFoundException("Data not found.");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();
        return View::create(null, Response::HTTP_OK);
     }
    }
