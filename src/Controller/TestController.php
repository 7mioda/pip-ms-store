<?php
namespace App\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

class TestController extends FOSRestController {
/**
*
* @Rest\Get("/test")
* @return View
*/
public function testAction(): View
{
$stripeClient = $this->get('flosch.stripe.client');
return View::create(['test' => 'OK', 'stripe' => $stripeClient]);
}
}
