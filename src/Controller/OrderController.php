<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Flosch\Bundle\StripeBundle\Stripe\StripeClient as BaseStripeClient;



class OrderController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("/orders", name="order_index")
     * @param OrderRepository $orderRepository
     * @return View
     * @Rest\View(serializerGroups={"service"})
     */
    public function index(OrderRepository $orderRepository)
    {
        $orders = $orderRepository->findAll();
        if (!$orders) {
            throw $this->createNotFoundException("Data not found.");
        }
        return View::create($orders, Response::HTTP_OK, []);
    }


    /**
     * @Rest\Post("/orders/new", name="order_new")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return View|FormInterface
     * @Rest\View(serializerGroups={"service"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }
        //$order->setTotalPrice(1000);
        $entityManager->persist($order);
        foreach ($form->get('orderLines')->getData() as $orderLine)
        {
            $orderLine->setOrder($order);
        }
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
     * @Rest\Get("order/submit-payment/{id}", name="order_payment")
     * @param Request $request
     * @param Order $order
     * @param BaseStripeClient $stripeClient
     * @return View|FormInterface
     */
    public function submitPayment(Request $request, Order $order, BaseStripeClient $stripeClient)
    {
        if (!$order) {
            throw $this->createNotFoundException("Data not found.");
        }
        $paymentToken  = $request->query->get('payment-token');
//        $total = $order->getTotalPrice() || 100;
        $stripeClient->createCharge(100, "eur", $paymentToken , null, 0, 'test');
        return View::create($order, Response::HTTP_OK, []);

    }

    /**
     * @Rest\Get("order/validate-order/{id}", name="order_payment")
     * @param Order $order
     * @param EntityManagerInterface $entityManager
     * @return View|FormInterface
     * @throws \Exception
     */
    public function validateOrder(Order $order, EntityManagerInterface $entityManager)
    {
        if (!$order) {
            throw $this->createNotFoundException("Data not found.");
        }
        $order->setValidatedAt(new DateTime());
        $entityManager->persist($order);
        $entityManager->flush();
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
