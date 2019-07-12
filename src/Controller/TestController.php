<?php
namespace App\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

use Swift_Mailer;
use Swift_Message;

class TestController extends FOSRestController {
    /**
     *
     * @Rest\Get("/test")
     * @param Swift_Mailer $mailer
     * @return View
     */
public function testAction(Swift_Mailer $mailer): View
{
$stripeClient = $this->get('flosch.stripe.client');
    $message = (new Swift_Message('Hello Email'))
        ->setFrom('plantify.it.donotreply@gmail.com')
        ->setTo('ahmededaly1993@gmail.com')
        ->setBody(
            'test'
        )
    ;

    $mailer->send($message);
    return View::create(['test' => 'OK', 'stripe' => $stripeClient]);
}
}
