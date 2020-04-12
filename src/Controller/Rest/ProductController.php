<?php

namespace App\Controller\Rest;

use App\Entity\Product\Product;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/products")
 */
class ProductController extends Controller
{
    /**
     * @Route("", methods={"GET"})
     */
    public function list()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        // dump($products);
        // die;
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $array = $serializer->normalize($products, 'array', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return View::create($array);
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function create()
    {
        return View::create([], Response::HTTP_CREATED);
    }
}
