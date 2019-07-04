<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class OrderController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("/orders", name="order_index")
     * @param OrderRepository $orderRepository
     * @return View
     * @Rest\View()
     */
    public function index(OrderRepository $orderRepository)
    {
        $order = $orderRepository->findAll();
        if (!$order) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($order, Response::HTTP_OK, []);
    }


    /**
     * @Rest\Post("/order/new", name="order_new")
     * @param Request $request
     * @return View|FormInterface
     * @Rest\View()
     */
    public function new(Request $request): View
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();
        return View::create($order, Response::HTTP_CREATED, []);

    }

    /**
     * @Rest\Get("/order/{id}", name="order_show")
     * @param Order $order
     * @return View
     */
    public function show(Order $order)
    {
        if (!$order) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($order, Response::HTTP_OK, []);

    }


    /**
     * @Rest\Post("order/edit/{id}", name="order_edit")
     * @param Request $request
     * @param Order $order
     * @return View|FormInterface
     */
    public function edit(Request $request, Order $order)
    {
        if (!$order) {
            throw $this->createNotFoundException("Data not found.");
        }
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();
        return View::create($order, Response::HTTP_OK, []);

    }


    /**
     * @Rest\Delete("/categories/delete/{id}", name="order_delete")
     * @param Order $order
     * @return View
     */
    public function delete( Order $order): View
    {
        if (!$order) {
            throw $this->createNotFoundException("Data not found.");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($order);
        $entityManager->flush();
        return View::create(null,Response::HTTP_OK);
    }

}
