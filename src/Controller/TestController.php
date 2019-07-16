<?php
namespace App\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\Error;
use App\Repository\ProductRepository;


class TestController extends FOSRestController {
    /**
     *
     * @Rest\Get("/test")
     * @param ProductRepository $mailer
     * @return View
     */
    public function testAction(ProductRepository $mailer): View
    {
       
        try {
            $mailer->findAllOrderedByName();
        } catch (Error $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return View::create(['test' => 'OK', 'stripe' => 'eeee']);
    }
}
/*"http://www.pepiniere-sainclair.com/images/vente-arbre-arbuste-pepiniere-nice-sainclair.png" */


/* public function testAction(Mailer $mailer): View
    {
        $stripeClient = $this->get('flosch.stripe.client');
        try {
            $mailer->sendResettingEmailMessage(
                [
                    'username' => 'username',
                    'confirmationLink' => 'confirmationLink',
                    'email' => 'mmekni.a.amine@gmail.com',
                    'imageProfile' => 'http://www.pepiniere-sainclair.com/images/vente-arbre-arbuste-pepiniere-nice-sainclair.png'
                ]
            );
        } catch (Error $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return View::create(['test' => 'OK', 'stripe' => $stripeClient]);
    }
} */