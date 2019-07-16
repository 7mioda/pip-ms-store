<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Form\DeliveryType;
use App\Repository\DeliveryRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Error;
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
     * @Rest\Get("/deliveries", name="delivery_index")
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
     * @Rest\Post("/deliveries/new", name="delivery_new")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return View|FormInterface
     * @Rest\View()
     */
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $delivery = new Delivery();
        $form = $this->createForm(DeliveryType::class, $delivery);
        $form->submit($request->request->all());

        if(!$form->isValid()){
            return $form;
        }
            $entityManager->persist($delivery);
            $entityManager->flush();
        return View::create($delivery, Response::HTTP_CREATED,[]);

    }

    /**
     * @Rest\Post("/deliveries/{id}/change-status", name="delivery_update_status")
     * @param Request $request
     * @param Delivery $delivery
     * @param EntityManagerInterface $entityManager
     * @return View
     * @throws \Exception
     */
    public function changeStatus(Request $request, Delivery $delivery, EntityManagerInterface $entityManager): View
    {
        try {
        $newStatus = $request->query->get('status');
        if (!$delivery) {
            throw $this->createNotFoundException("Data not found.");
        }
        if($newStatus === 'delivered') {
            $delivery->setDeliveredAt(new DateTime());
        }
        $delivery->setStatus($newStatus);
        $entityManager->persist($delivery);
        $entityManager->flush();
        return View::create($delivery, Response::HTTP_OK, []);
        } catch (Error $error) {
            return View::create($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, []);
        }
    }




    /**
     * @Rest\Get("/deliveries/{id}", name="delivery_show")
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
     * @Rest\Post("/deliveries/edit/{id}", name="delivery_edit")
     * @param Request $request
     * @param Delivery $delivery
     * @param EntityManagerInterface $entityManager
     * @return View|FormInterface
     */
    public function edit(Request $request, Delivery $delivery, EntityManagerInterface $entityManager): View
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
        $entityManager->persist($delivery);
        $entityManager->flush();
        return View::create($delivery, Response::HTTP_OK, []);
    }


    /**
     * @Rest\Delete("/deliveries/delete/{id}", name="delivery_delete")
     * @param Delivery $delivery
     * @param EntityManagerInterface $entityManager
     * @return View
     */
    public function delete(Delivery $delivery, EntityManagerInterface $entityManager): View
    {
        if (!$delivery) {
            throw $this->createNotFoundException("Data not found.");
        }
        $entityManager->remove($delivery);
        $entityManager->flush();
        return View::create(null,Response::HTTP_OK);
    }
}
