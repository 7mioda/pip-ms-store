<?php
namespace App\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use App\Controller\Mailer;

class TestController extends FOSRestController {
/**
*
* @Rest\Get("/test")
* @return View
*/
public function testAction(Mailer $mailer): View
{
$stripeClient = $this->get('flosch.stripe.client');
$mailer->sendResettingEmailMessage([]);
return View::create(['test' => 'OK', 'stripe' => $stripeClient]);
}
}
