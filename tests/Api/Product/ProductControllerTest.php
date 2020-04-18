<?php

namespace App\Tests\Api\Product;

use App\Tests\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Response;
use App\DataFixtures\ProductFixtures;
use App\Entity\Product\Product;
use App\Entity\Product\ProductVariantInterface;

class ProductTest extends AbstractControllerTest
{
    public function testList()
    {
        $this->loadFixture(new ProductFixtures());

        $expectedResponse = [
            'page' => 1,
            'perPage' => 50,
            'total' => 3,
            'items' => [
                [
                    'code' => 'code1',
                    'name' => 'name1',
                    'description' => 'description1',
                    'stock' => 10,
                    'price' => 13,
                    'salePrice' => 12,
                    'cost' => 10,
                ], [
                    'code' => 'code2',
                    'name' => 'name2',
                    'description' => 'description2',
                    'stock' => 20,
                    'price' => 23,
                    'salePrice' => 22,
                    'cost' => 20,
                ], [
                    'code' => 'code3',
                    'name' => 'name3',
                    'description' => 'description3',
                    'stock' => 30,
                    'price' => 33,
                    'salePrice' => 32,
                    'cost' => 30,
                ]
            ],
        ];

        $response = $this->client->get('/api/products');

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertResponseEquals($expectedResponse, $response);
    }

    public function testFetchSingleProduct()
    {
        $this->loadFixture(new ProductFixtures);

        $expectedResponse = [
            'name' => 'name1',
            'code' => 'code1',
            'description' => 'description1',
            'stock' => 10,
            'price' => 13,
            'salePrice' => 12,
            'cost' => 10,
        ];

        $response = $this->client->get('/api/products/code1');

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertResponseEquals($expectedResponse, $response);
    }

    public function testFailFetchSingleProduct()
    {
        $this->loadFixture(new ProductFixtures);

        $productCode = 'INVALID-CODE';

        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);
        $this->expectExceptionMessage(sprintf('Product with code[%s] not found', $productCode));

        $this->client->get('/api/products/' . $productCode);
    }

    public function testPost()
    {
        $this->loadFixture(new ProductFixtures());

        $newProductPayload = [
            'name' => 'New Product',
            'stock' => 1,
            'cost' => 18,
            'price' => 20,
            'sale_price' => 19,
            'enabled' => true,
            'description' => 'new product description',
        ];

        $response = $this->client->post('/api/products', ['json' => $newProductPayload]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        // $this->assertResponseEquals($newProductPayload, $response);

        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        /** @var Product $newProduct */
        $newProduct = $em->getRepository(Product::class)->find(4);
        /** @var ProductVariantInterface $variant */
        $variant = $newProduct->getVariants()->first();

        $this->assertEquals($newProductPayload['name'], $newProduct->getName());
        $this->assertEquals($newProductPayload['description'], $newProduct->getDescription());
        $this->assertEquals($newProductPayload['stock'], $variant->getOnHand());
        $this->assertEquals($newProductPayload['cost'], $variant->getCost());
        $this->assertEquals($newProductPayload['price'], $variant->getPrice());
        $this->assertEquals($newProductPayload['sale_price'], $variant->getSalePrice());
        $this->assertEquals($newProductPayload['enabled'], $newProduct->isEnabled());
    }

    public function testDeleteProduct()
    {
        $this->loadFixture(new ProductFixtures);

        $response = $this->client->delete('/api/products/code1');

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertResponseEquals(null, $response);

        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository(Product::class);

        $deletedProduct = $repository->find(1);

        $this->assertEquals(null, $deletedProduct);
    }

    public function testFailDeleteProduct()
    {
        $this->loadFixture(new ProductFixtures);

        $productCode = 'INVALID-CODE';

        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);
        $this->expectExceptionMessage(sprintf('Product with code[%s] not found', $productCode));

        $this->client->delete('/api/products/' . $productCode);
    }

    public function testFailEditProduct()
    {
        $this->loadFixture(new ProductFixtures);

        $productId = 'INVALID-CODE';

        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);
        $this->expectExceptionMessage(sprintf('Product with code[%s] not found', $productId));

        $this->client->put('/api/products/' . $productId);
    }

    public function testEditProdut()
    {
        $this->loadFixture(new ProductFixtures);

        $requestBody = [
            'name' => 'name edited',
            'description' => 'description edited'
        ];

        $response = $this->client->put('/api/products/code1', ['json' => $requestBody]);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertResponseEquals(null, $response);

        $manager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $manager->getRepository(Product::class);

        $editedProduct = $repository->findOneBy(['code' => 'code1']);

        //Only can change name and description of a product
        $this->assertEquals($requestBody['name'], $editedProduct->getName());
        $this->assertEquals($requestBody['description'], $editedProduct->getDescription());
    }
}
