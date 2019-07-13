<?php

namespace App\Controller;


use App\Entity\FlashSale;
use App\Form\FlashSaleType;
use App\Repository\FlashSaleRepository;
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
     * @param FlashSaleRepository $flashSaleRepository
     * @return View
     * @Rest\View()
     */
    public function index(FlashSaleRepository $flashSaleRepository)
    {
        $flashSale = $flashSaleRepository->findAll();
        if (!$flashSale) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($flashSale, Response::HTTP_OK, []);
    }


    /**
     * @Rest\Post("/flash-sales/new", name="flash_sale_new")
     * @param Request $request
     * @return View|FormInterface
     * @Rest\View()
     */
    public function new(Request $request)
    {
        $flashSale = new FlashSale();
        $form = $this->createForm(FlashSaleType::class, $flashSale);
        $form->submit($request->request->all());

        if(!$form->isValid()){
            return $form;
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($flashSale);
        $entityManager->flush();
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
     * @return View|FormInterface
     */
    public function edit(Request $request, FlashSale $flashSale)
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
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($flashSale);
        $entityManager->flush();
        return View::create($flashSale, Response::HTTP_OK, []);

    }


    /**
     * @Rest\Delete("/flash-sales/delete/{id}", name="flash_sale_delete")
     * @param FlashSale $flashSale
     * @return View
     */
    public function delete( FlashSale $flashSale): View
    {
        if (!$flashSale) {
            throw $this->createNotFoundException("Data not found.");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($flashSale);
        $entityManager->flush();
        return View::create(null,Response::HTTP_OK);

    }
}
