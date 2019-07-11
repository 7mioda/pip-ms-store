<?php

namespace App\Controller;

use App\Entity\OrderLine;
use App\Form\OrderLineType;
use App\Repository\OrderLineRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class OrderLineController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("/orderLines", name="order_line_index")
     * @param OrderLineRepository $orderLineRepository
     * @return View
     * @Rest\View()
     */
    public function index(OrderLineRepository $orderLineRepository)
    {
        $orderLine = $orderLineRepository->findAll();
        if (!$orderLine) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($orderLine, Response::HTTP_OK, []);

    }


    /**
     * @Rest\Post("/order/line/new", name="order_line_new")
     * @param Request $request
     * @return View|FormInterface
     * @Rest\View()
     */
    public function new(Request $request)
    {
        $orderLine = new OrderLine();
        $form = $this->createForm(OrderLineType::class, $orderLine);
        $form->submit($request->request->all());

        if(!$form->isValid()){
            return $form;
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($orderLine);
        $entityManager->flush();
        return View::create($orderLine, Response::HTTP_CREATED,[]);

    }


    /**
     * @Rest\Get("/order/line/{id}", name="order_line_show")
     * @param OrderLine $orderLine
     * @return View
     */
    public function show(OrderLine $orderLine): View
    {
        if (!$orderLine) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($orderLine, Response::HTTP_OK, []);

    }


    /**
     * @Rest\Post("order/line/edit/{id}", name="order_line_edit")
     * @param Request $request
     * @param OrderLine $orderLine
     * @return View|FormInterface
     */
    public function edit(Request $request, OrderLine $orderLine)
    {
        if (!$orderLine) {
            throw $this->createNotFoundException("Data not found.");
        }
        $form = $this->createForm(OrderLineType::class, $orderLine);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($orderLine);
        $entityManager->flush();
        return View::create($orderLine, Response::HTTP_OK, []);

    }


    /**
     * @Rest\Delete("/categories/delete/{id}", name="order_line_delete")
     * @param OrderLine $orderLine
     * @return View
     */
    public function delete( OrderLine $orderLine)
    {
        if (!$orderLine) {
            throw $this->createNotFoundException("Data not found.");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($orderLine);
        $entityManager->flush();
        return View::create(null,Response::HTTP_OK);
    }

}
