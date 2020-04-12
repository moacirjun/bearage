<?php

namespace App\Controller\Rest;

use App\Dto\Product\ProductDtoAssembler;
use App\Entity\Product\Product;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

        $parserProducts = array_map(function ($item) {
            return ProductDtoAssembler::writeDto($item);
        }, $products);

        return View::create($parserProducts);
    }

    /**
     * @Route("", methods={"POST"})
     */
    public function create()
    {
        return View::create([], Response::HTTP_CREATED);
    }
}
