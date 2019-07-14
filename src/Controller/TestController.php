<?php
namespace App\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\Error;


class TestController extends FOSRestController {
    /**
     *
     * @Rest\Get("/test")
     * @param Mailer $mailer
     * @return View
     */
    public function testAction(Mailer $mailer): View
    {
        $stripeClient = $this->get('flosch.stripe.client');
        try {
            $mailer->sendResettingEmailMessage(
                [
                    'username' => 'username',
                    'confirmationLink' => 'confirmationLink',
                    'email' => 'ahmededaly1993@gmail.com'
                ]
            );
        } catch (Error $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return View::create(['test' => 'OK', 'stripe' => $stripeClient]);
    }
}
