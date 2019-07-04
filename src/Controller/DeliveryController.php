<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Form\DeliveryType;
use App\Repository\DeliveryRepository;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;


class DeliveryController extends AbstractController
{

    /**
     * @Rest\Get("/delivery", name="delivery_index")
     * @param DeliveryRepository $deliveryRepository
     * @return View
     * @Rest\View()
     */
    public function index(DeliveryRepository $deliveryRepository)
    {   $delivery = $deliveryRepository->findAll();
        if (!$delivery) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($delivery, Response::HTTP_OK, []);
    }


    /**
     * @Rest\Post("/delivery/new", name="delivery_new")
     * @param Request $request
     * @return View|FormInterface
     * @Rest\View()
     */
    public function new(Request $request)
    {
        $delivery = new Delivery();
        $form = $this->createForm(DeliveryType::class, $delivery);
        $form->submit($request->request->all());

        if(!$form->isValid()){
            return $form;
        }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($delivery);
            $entityManager->flush();
       // return View::create($delivery, Response::HTTP_CREATED, []);
        return View::create($delivery, Response::HTTP_CREATED,[]);
    }




    /**
     * @Rest\Get("/delivery/{id}", name="delivery_show")
     * @param Delivery $delivery
     * @return View
     */
    public function show(Delivery $delivery): View
    {
        if (!$delivery) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($delivery, Response::HTTP_OK, []);

    }


    /**
     * @Rest\Post("delivery/edit/{id}", name="delivery_edit")
     * @param Request $request
     * @param Delivery $delivery
     * @return View|FormInterface
     */
    public function edit(Request $request, Delivery $delivery): View
    {
        if (!$delivery) {
            throw $this->createNotFoundException("Data not found.");
        }
        $form = $this->createForm(DeliveryType::class, $delivery);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($delivery);
        $entityManager->flush();
        return View::create($delivery, Response::HTTP_OK, []);
    }


    /**
     * @Rest\Delete("/delivery/delete/{id}", name="delivery_delete")
     * @param Delivery $delivery
     * @return View
     */
    public function delete(Delivery $delivery): View
    {
        if (!$delivery) {
            throw $this->createNotFoundException("Data not found.");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($delivery);
        $entityManager->flush();
        return View::create(null,Response::HTTP_OK);
    }
}
