<?php


namespace App\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UtilsController extends AbstractController
{
    protected $callbacks;
    protected $routes;

    public function __construct()
    {
        // this is an object to remove params from json when serialized
        $this->callbacks = [];

    }

    /**
     * @param $object
     * @param array $context
     * @return JsonResponse
     */
    protected function getJsonResponse($object, $context = [])
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setSerializer($this->callbacks);
        $serializer = new Serializer([
            new DateTimeNormalizer(),
            new ArrayDenormalizer(),
            new DataUriNormalizer(),
            $normalizer,
        ], [new JsonEncoder()]);

        return new JsonResponse($serializer->serialize($object, 'json', $context), 200, [], true);
    }

    /**
     * @param Request $request
     * @param $type
     * @return object
     * @Rest\Post()
     */
    protected function getObjectFromRequest(Request $request, $type)
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setSerializer($this->callbacks);
        $serializer = new Serializer([
            new DateTimeNormalizer(),
            new ArrayDenormalizer(),
            new DataUriNormalizer(),
            $normalizer,
        ], [new JsonEncoder()]);

        return $serializer->deserialize(json_encode($request->request->all()), $type, 'json');
    }


}