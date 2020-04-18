<?php

namespace App\Controller\Rest;

use App\Dto\Product\ProductDto;
use App\Dto\Product\ProductDtoAssembler;
use App\Entity\Product\Product;
use App\Factory\Product\ProductFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as Controller;
use Symfony\Component\HttpFoundation\Request;
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
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $newProduct = (new ProductFactory)->make(
            $request->get('name'),
            $request->get('description'),
            (int) $request->get('stock'),
            (float) $request->get('price'),
            (float) $request->get('sale_price'),
            (float) $request->get('cost'),
            $request->get('code')
        );
        $newProduct->disable();

        if (true === $request->get('enabled')) {
            $newProduct->enable();
        }

        $manager->persist($newProduct);
        $manager->flush();

        return View::create(ProductDtoAssembler::writeDto($newProduct), Response::HTTP_CREATED);
    }

    /**
     * @Route("/{code}", methods={"GET"})
     */
    public function fetchSingle(Request $request, EntityManagerInterface $manager)
    {
        $productId = $request->attributes->get('code');
        $repository = $manager->getRepository(Product::class);

        $product = $repository->findOneBy(['code' => $productId]);

        if (!$product instanceof Product) {
            throw new EntityNotFoundException(sprintf('Product with code[%s] not found', $productId));
        }

        return View::create(ProductDtoAssembler::writeDto($product), Response::HTTP_OK);
    }

    /**
     * @Route("/{code}", methods={"DELETE"})
     */
    public function delete(Request $request, EntityManagerInterface $manager)
    {
        $productCode = $request->attributes->get('code');
        $repository = $manager->getRepository(Product::class);

        $product = $repository->findOneBy(['code' => $productCode]);

        if (!$product instanceof Product) {
            throw new EntityNotFoundException(sprintf('Product with code[%s] not found', $productCode));
        }

        $manager->remove($product);
        $manager->flush();

        return View::create(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{code}", methods={"PUT"})
     */
    public function edit(Request $request, EntityManagerInterface $manager)
    {
        $productId = $request->attributes->get('code');
        $repository = $manager->getRepository(Product::class);

        $product = $repository->findOneBy(['code' => $productId]);

        if (!$product instanceof Product) {
            throw new EntityNotFoundException(sprintf('Product with code[%s] not found', $productId));
        }

        if ($name = $request->get('name')) {
            $product->setName($name);
        }

        if ($description = $request->get('description')) {
            $product->setDescription($description);
        }

        $manager->persist($product);
        $manager->flush();

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}
