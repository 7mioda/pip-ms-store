<?php
namespace App\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\Error;


class TestController extends FOSRestController {
    /**
     *
     * @Rest\Get("/test")
     * @param Mailer $mailer
     * @return View
     */
    public function testAction(Request $request): View
    {
        $stripeClient = $this->get('flosch.stripe.client');
//        $stripeClient->
        $paymentToken  = $request->query->get('payment-token');
        $stripeClient->createCharge(100, "eur", $paymentToken , null, 0, 'test');
        return View::create(['test' => 'OK', 'stripe' => $stripeClient]);
    }
}
