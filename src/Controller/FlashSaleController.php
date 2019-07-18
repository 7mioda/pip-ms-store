<?php

namespace App\Controller;


use App\Entity\FlashSale;
use App\Form\FlashSaleType;
use App\Repository\FlashSaleRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class FlashSaleController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("/flash-sales", name="flash_sale_index")
     * @param Request $request
     * @param FlashSaleRepository $flashSaleRepository
     * @return View
     * @Rest\View(serializerGroups={"service"})
     */
    public function index(Request $request, FlashSaleRepository $flashSaleRepository)
    {
        $offset = $request->query->get('offset');
        $limit = $request->query->get('limit');
        if($offset && $limit){
            $flashSale = $flashSaleRepository->getPagination($offset, $limit);
        } else {
            $flashSale = $flashSaleRepository->findAll();
        }
        if (!$flashSale) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($flashSale, Response::HTTP_OK, []);
    }


    /**
     * @Rest\Post("/flash-sales/new", name="flash_sale_new")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param Uploader $uploader
     * @param Publisher $publisher
     * @return View|FormInterface
     * @Rest\View(serializerGroups={"service"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, Uploader $uploader, Publisher $publisher)
    {
        $flashSale = new FlashSale();
        $form = $this->createForm(FlashSaleType::class, $flashSale);
        $form->submit($request->request->all());

        if(!$form->isValid()){
            return $form;
        }
        $imageFile = $request->files->get('image');
        if($imageFile){
            $image = $uploader->uploadImage($request->files->get('image'), []);
            $flashSale->setImage(($image));
        }
        $entityManager->persist($flashSale);
        $entityManager->flush();
        $publisher->publishFlashSale($flashSale);
        return View::create($flashSale, Response::HTTP_CREATED,[]);

    }


    /**
     * @Rest\Get("/flash-sales/{id}", name="flash_sale_show")
     * @param FlashSale $flashSale
     * @return View
     */
    public function show(FlashSale $flashSale): View
    {
        if (!$flashSale) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($flashSale, Response::HTTP_OK, []);

    }


    /**
     * @Rest\Post("flash-sales/edit/{id}", name="flash_sale_edit")
     * @param Request $request
     * @param FlashSale $flashSale
     * @param EntityManagerInterface $entityManager
     * @param Uploader $uploader
     * @return View|FormInterface
     */
    public function edit(Request $request, FlashSale $flashSale, EntityManagerInterface $entityManager, Uploader $uploader)
    {
        if (!$flashSale) {
            throw $this->createNotFoundException("Data not found.");
        }
        $form = $this->createForm(FlashSaleType::class, $flashSale);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        $imageFile = $request->files->get('image');
        if($imageFile){
            $image = $uploader->uploadImage($request->files->get('image'), []);
            $flashSale->setImage(($image));
        }
        $entityManager->persist($flashSale);
        $entityManager->flush();
        return View::create($flashSale, Response::HTTP_OK, []);

    }


    /**
     * @Rest\Delete("/flash-sales/delete/{id}", name="flash_sale_delete")
     * @param FlashSale $flashSale
     * @param EntityManagerInterface $entityManager
     * @return View
     */
    public function delete( FlashSale $flashSale, EntityManagerInterface $entityManager): View
    {
        if (!$flashSale) {
            throw $this->createNotFoundException("Data not found.");
        }
        $entityManager->remove($flashSale);
        $entityManager->flush();
        return View::create(null,Response::HTTP_OK);

    }
}
